<?php

namespace App\Providers;

use App\Link;
use App\Policies\ChapterPolicy;
use App\Policies\LinkPolicy;
use App\Policies\UserPolicy;
use App\Policies\VideoPolicy;
use App\User;
use App\Video;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Video::class => VideoPolicy::class,
        Chapter::class => ChapterPolicy::class,
        Link::class => LinkPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
