<?php

namespace App\Providers;

use App\Affiliate;
use App\Chapter;
use App\Link;
use App\Observers\ChapterObserver;
use App\Observers\LinkObserver;
use App\Observers\UserObserver;
use App\Observers\VideoObserver;
use App\Services\WebsiteCheckout;
use App\User;
use App\Video;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MasteringNovaProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerContainers();
        $this->registerMacros();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerListeners();
        $this->updateSchema();
        $this->registerBladeDirectives();
        $this->registerObservers();
        $this->registerGates();
        $this->registerReferer();

        if (app()->environment() != 'production') {
            $this->registerNonProductionRoutes();
        }
    }

    protected function registerNonProductionRoutes()
    {
        $this->loadRoutesFrom(base_path('routes/web-non-production.php'));
    }

    protected function registerGates()
    {
        /*
         * If the video is not active, return false.
         * If the user is logged in, return true.
         * If the video is free, return true.
         */
        Gate::define('play-video', function (?User $user, Video $video) {
            if ($video->is_active == false) {
                return false;
            }

            if (Auth::id()) {
                return true;
            }

            return $video->is_free;
        });
    }

    protected function registerMacros()
    {
        // Include all files from the Macros folder.
        Collection::make(glob(app_path('Macros').'/*.php'))
                  ->mapWithKeys(function ($path) {
                      return [$path => pathinfo($path, PATHINFO_FILENAME)];
                  })
                  ->each(function ($macro, $path) {
                      require_once $path;
                  });
    }

    protected function registerContainers()
    {
        $this->app->singleton('website-checkout', function () {
            return new WebsiteCheckout();
        });
    }

    protected function registerReferer()
    {
        if (request()->has('ref')) {
            $name = request()->input('ref');
            $affiliate = Affiliate::firstWhere('name', $name);

            if ($affiliate) {
                session(['referer' => $affiliate->domain]);
            }
        } elseif (request()->headers->get('referer') != null) {
            $domain = request()->headers->get('referer');
            $affiliate = Affiliate::firstWhere('domain', $this->baseDomain($domain));

            if ($affiliate) {
                session(['referer' => $affiliate->domain]);
            }
        };

        // Testing purposes in a non-production environment.
        if (env('REFERER') && app()->environment() != 'production') {
            session(['referer' => $this->baseDomain(env('REFERER'))]);
        };

        info('session referer saved via service provider with value ' . session('referer'));
    }

    protected function registerListeners()
    {
        Event::listen('auth.login', function ($user) {
            $user->last_login_at = now();
            $user->save();
        });
    }

    protected function registerBladeDirectives()
    {
        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });

        Blade::if('routename', function ($name) {
            return Route::currentRouteName() == $name;
        });

        // Register checkout return url.
        Route::any(
            'paddle/thanks/{checkout}',
            '\App\Features\Purchased\Controllers\PurchasedController@thanks'
        )
             ->name('purchased.thanks');
    }

    protected function updateSchema()
    {
        Schema::defaultStringLength(191);
    }

    protected function registerObservers()
    {
        User::observe(UserObserver::class);
        Video::observe(VideoObserver::class);
        Chapter::observe(ChapterObserver::class);
        Link::observe(LinkObserver::class);
    }

    function addScheme($url, $scheme = 'http://')
    {
        return parse_url($url, PHP_URL_SCHEME) === null ? $scheme . $url : $url;
    }

    function baseDomain($url)
    {
        $url = $this->addScheme($url);

        $urlData = parse_url($url);
        $urlHost = isset($urlData['host']) ? $urlData['host'] : '';
        $isIP = (bool)ip2long($urlHost);
        if ($isIP) { /** To check if it's ip then return same ip */
            return $urlHost;
        }
        /** Add/Edit you TLDs here */
        $urlMap = array('io','dev','com', 'uk', 'pt', 'org', 'net');

        $host = "";
        $hostData = explode('.', $urlHost);
        if (isset($hostData[1])) { /** To check "localhost" because it'll be without any TLDs */
            $hostData = array_reverse($hostData);

            if (array_search($hostData[1] . '.' . $hostData[0], $urlMap) !== false) {
                $host = $hostData[2] . '.' . $hostData[1] . '.' . $hostData[0];
            } elseif (array_search($hostData[0], $urlMap) !== false) {
                $host = $hostData[1] . '.' . $hostData[0];
            }
            return $host;
        }
        return ((isset($hostData[0]) && $hostData[0] != '') ? $hostData[0] : 'error no domain'); /* You can change this error in future */
    }
}
