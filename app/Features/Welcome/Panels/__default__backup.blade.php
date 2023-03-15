@extends('layouts.default')

@section('body')

    <section id="header_with_navbar" class="hero-pattern-topography pb-10">
        <!-- Header -->
        <div class="w-11/12 lg:w-10/12 mx-auto flex md:flex-wrap">

            <!-- Header Left side -->
            <div class="w-full lg:w-1/2 lg:px-5 leading-normal">

                <!-- Hero text -->
                <h1 class="text-3xl sm:text-4xl lg:text-4xl xl:text-5xl hd:text-6xl text-center lg:text-left md:text-6xl font-bold text-white leading-tight">
                Your Ultimate Course to demystify Laravel Nova from A to Z
                </h1>

                <!-- Hero featured items -->
                <div class="flex flex-wrap sm:flex-no-wrap items-start mt-8">
                    <div class="pr-0 sm:pr-6"><x-feathericon-video class="s-8 sm:s-12 xl:s-16 text-red-500"/></div>
                    <div class="text-xl sm:text-2xl xl:text-2xl hd:text-3xl text-indigo-200 sm:font-bold pt-2 sm:pt-0">
                    {{ $videos->count() }} Videos, +5 hours recordings, from installation to advanced UI Features creation
                    </div>
                </div>

                <div class="flex flex-wrap sm:flex-no-wrap items-start mt-8">
                    <div class="pr-0 sm:pr-6"><x-feathericon-image class="s-8 sm:s-12 xl:s-16 text-red-500"/></div>
                    <div class="text-xl sm:text-2xl xl:text-2xl hd:text-3xl text-indigo-200 sm:font-bold pt-2 sm:pt-0">
                    UI Components and Resources deep dives, UI troubleshooting, Resource testing, and much more!
                    </div>
                </div>

                @if(env('LAUNCHED') == 1)
                <div class="flex items-start mt-8 justify-center sm:justify-start md:justify-center lg:justify-start">
                    <div class="hidden sm:block md:hidden lg:block w-16 xl:mr-6">&nbsp;</div>
                    <div class="flex flex-wrap sm:flex-no-wrap justify-center items-center">
                        @guest
                        <a class="w-full sm:w-auto flex-shrink-0" href="{{ route('checkout.paylink') }}" target='_self'>
                            <button class="h-20 w-full p-5 text-base sm:text-2xl font-bold bg-indigo-100 text-indigo-900 rounded rounded-lg flex items-center justify-center sm:justify-start sm:mr-4 hover:bg-white hover:text-red-500">
                                <x-feathericon-thumbs-up class="block hidden hd:block s-8 mr-4" />
                                <div class="text-left text-base md:text-2xl lg:text-xl lg:font-bold">
                                    Buy Now<span class="line-through text-gray-500">$ {{ WebsiteCheckout::make()->price()->amount->original }}</span> $ {{ WebsiteCheckout::make()->price()->amount->checkout }}
                                </div>
                            </button>
                        </a>
                        @endguest
                        <a class="w-full" href="{{ route('videos') }}">
                            <button class="h-20 {{ Auth::guest() ? 'sm:ml-4' : '' }} w-full mt-4 sm:mt-0 text-center p-5 font-bold bg-indigo-900 text-indigo-200 rounded rounded-lg flex items-center justify-center md:justify-start hover:bg-indigo-600 hover:text-white">
                                <x-bi-camera-video class="block hidden hd:block s-8 mr-4" />
                                <div class="text-left text-base md:text-2xl lg:text-xl lg:font-bold">Watch Videos</div>
                            </button>
                        </a>
                    </div>
                </div>

                @guest
                @if(WebsiteCheckout::make()->price()->discount->percentage > 0)
                <div class="flex items-start mt-3 md:justify-center lg:justify-start">
                    <div class="hidden sm:block lg:block w-16 xl:mr-6">&nbsp;</div>
                    <div class="w-full sm:w-2/3 text-sm sm:text-left md:text-center lg:text-left">
                        Hey, looks like you're coming From <span class="text-red-500 font-bold">{{ WebsiteCheckout::make()->price()->request->country->name }}</span>, so I am
                        already applying a <span class="text-red-500 font-bold">{{ WebsiteCheckout::make()->price()->discount->percentage }}%</span> discount for you! <a class="link-dark" href="https://en.wikipedia.org/wiki/Purchasing_power_parity" target="_blank">I am in favor of Purchase Power Parity.</a>
                    </div>
                </div>
                @endif
                @endguest

                @guest
                <div class="flex items-start mt-3 md:justify-center lg:justify-start">
                    <div class="hidden sm:block md:hidden lg:block w-16 xl:mr-6">&nbsp;</div>
                    <div class="w-full sm:w-2/3 text-sm text-center sm:text-left md:text-center lg:text-left">
                        @if(env('OTHER_PURCHASE_OPTIONS') == 1 && WebsiteCheckout::make()->price()->discount->percentage == 0 && WebsiteCheckout::allowOptionsFromThisCountry())
                        <a class="-mt-2 block underline text-red-500" href="{{ route('welcome.options') }}">Or purchase in 2 times</a>
                        <p class="mt-2">
                        @else
                        <p>
                        @endif
                        BLACK FRIDAY! <span class="text-red-500 font-bold">50% discount</span> until end of the year!<br/>
                        Price excludes VAT, if applicable
                        </p>
                    </div>
                </div>
                @endguest
                @else
                {{-- Subscription mode -> Before launching --}}
                @routename('welcome')
                <form method="POST" action="{{ route('welcome.subscribed') }}">
                    <input type="hidden" name="bag" value="upper" />
                    @csrf
                    @honeypot

                    <div class="flex items-start mt-8 md:justify-center lg:justify-start">
                        <div class="hidden sm:block md:hidden lg:block w-16 xl:mr-6">&nbsp;</div>
                        <div class="flex flex-wrap sm:flex-no-wrap justify-center items-center">

                            <div class="w-64 sm:w-auto mb-2 sm:mb-0 h-16 bg-indigo-100 rounded-lg flex items-center">
                                <input class="w-64 sm:w-auto focus:no-underline focus:outline-none px-4 bg-indigo-100 text-black placeholder-indigo-900 text-xl" type="text" name="email" placeholder="Your Email">
                            </div>
                            <button class="cursor-pointer w-64 sm:w-auto h-16 sm:ml-2 sm:mt-0 text-center px-6 font-bold bg-red-500 text-white rounded rounded-lg flex items-center justify-center md:justify-start hover:bg-red-200 hover:text-red-500 transition duration-100">
                                <x-heroicon-o-thumb-up class="block lg:hidden xl:block s-8 mr-2" />
                                <div class="text-left text-base md:text-2xl lg:text-xl lg:font-bold">Keep me updated</div>
                            </button>
                        </div>
                    </div>
                    <div class="justify-center sm:justify-start md:justify-center flex items-start mt-2 lg:justify-start">
                        <div class="hidden sm:block w-16 xl:mr-6">&nbsp;</div>
                        <div class="flex flex-wrap sm:flex-no-wrap justify-center items-center text-red-500">
                        @error('email')
                        {{ $message }}
                        @enderror
                        </div>
                    </div>
                </form>
                @endroutename
                @routename('welcome.subscribed')
                    <div class="justify-center sm:justify-start md:justify-center flex items-start mt-2 lg:justify-start">
                        <div class="hidden sm:block w-16 xl:mr-6">&nbsp;</div>
                        <div class="flex flex-wrap sm:flex-no-wrap justify-center items-center">
                        <p class="text-green-500 font-bold text-xl">Thanks! I'll keep you posted and you'll have a special launch discount!</p>
                        </div>
                    </div>
                @endif
                @endroutename
            </div>

            <!-- Header right side -->
            <div class="w-full md:pt-12 lg:pt-0 lg:w-1/2 hidden md:block ">
                <div class="owl-carousel owl-theme rounded rounded-lg border-4 border-red-500">
                    @foreach(optional($website)->getMedia() ?? [] as $media)
                        <div class="item p-2"><img class="rounded rounded-lg" src="{{ $media->getUrl('featured') }}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial - David Hemphill -->
    <section class="w-full py-8 bg-indigo-900">
        <div class="w-11/12 md:w-5/6 lg:w-2/3 xl:w-1/2 flex flex-wrap items-center justify-center mx-auto">
            <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 pb-6 md:pb-0">
                <img src="{{ url('images/tweet-hemphill.jpg') }}" class="mx-auto border-4 p-2 border-indigo-100 rounded-full h-48 w-48">
            </div>
            <div class="text-base lg:text-2xl w-full md:w-1/2 lg:w-2/3 text-indigo-100 font-bold">
                "I'd probably pick up this in-depth course on Laravel Nova if I was you. Looks like there's stuff in there I didn't even know was possible!"
                <br>
                <p class="pt-2 not-italic text-xl font-normal"><a class="link-dark" href="https://twitter.com/davidhemphill" target="_blank">@davidhemphill</a> - <a class="link-dark" href="https://davidhemphill.com/" target="_blank">Laravel Nova Co-Creator</a> on a <a class="link-dark" target="_blank" href="https://twitter.com/davidhemphill/status/1312127821813215232">Twitter post</a></p>
            </div>
        </div>
    </section>

    <!-- Hero section after header -->
    <section id="hero_after_header" class="bg-indigo-100 w-full py-8">
        <div class="w-11/12 md:w-5/6 lg:w-3/4 hd:w-1/2 mx-auto">
            <h2 class="text-2xl md:text-4xl font-bold text-indigo-900 text-center">Not having that Nova Feature working as you want?</h2>
            <h3 class="text-base md:text-2xl font-bold text-indigo-700 text-center">Start saving hundreds of hours by learning how to build that <i>impossible</i> Nova Feature in a highly comprehensive way, full of real examples!</h3>
        </div>
    </section>

    <!-- Highlighted features -->
    <section id="features" class="bg-richblack-500 w-full pt-24 pb-0 lg:pb-24">
        <div class="w-11/12 lg:w-10/12 mx-auto flex flex-wrap lg:flex-no-wrap justify-center">

            <!-- 40+ Tutorials -->
            <div class="w-full xl:w-1/3 bg-indigo-100 rounded rounded-lg p-5 relative mb-20 lg:mb-0">
                <div class="absolute -ml-5 -mt-16 top-0 w-full text-center">
                    <div class="rounded rounded-full p-6 bg-richblack-500 inline-block mx-auto text-center ">
                        <x-bi-collection-play class="s-20 text-white mx-auto" />
                    </div>
                </div>
                <div class="text-3xl text-indigo-900 text-center mt-12 font-bold">{{ $totalVideos }} Video Tutorials</div>
                <div class="text-indigo-900 text-center mt-2"><span class="text-red-600 font-bold">Save literally hundreds of hours</span> <br/>From installation to Production deployment, passing by the creation of UI Features, Multi-tenancy, Authorization, Best practices, Performance optimization, you name it</div>
            </div>

            <!-- Deep Dives -->
            <div class="w-full xl:w-1/3 bg-indigo-100 rounded rounded-lg lg:ml-5 p-5 relative mb-20 lg:mb-0">
                <div class="absolute -ml-5 -mt-16 top-0 w-full text-center">
                    <div class="rounded rounded-full p-6 bg-richblack-500 inline-block mx-auto text-center ">
                        <x-bi-window class="s-20 text-white mx-auto" />
                    </div>
                </div>
                <div class="text-3xl text-indigo-900 text-center mt-12 font-bold">Advanced Deep Dives</div>
                <div class="text-indigo-900 text-center mt-2"><span class="text-red-600 font-bold">Lots of hidden gems advanced topics</span> <br/>From advanced UI components, performance optimizations, multi-tenancy, testing, you'll deep dive into the architecture of Nova to build the best possible Admin Panel</div>
            </div>

            <!-- Fundamentals explained -->
            <div class="w-full xl:w-1/3 bg-indigo-100 rounded rounded-lg p-5 lg:ml-5 relative mb-20 lg:mb-0">
                <div class="absolute -ml-5 -mt-16 top-0 w-full text-center">
                    <div class="rounded rounded-full p-6 bg-richblack-500 inline-block mx-auto text-center ">
                        <x-bi-book class="s-20 text-white mx-auto" />
                    </div>
                </div>
                <div class="text-3xl text-indigo-900 text-center mt-12 font-bold">The Fundamentals Explained</div>
                <div class="text-indigo-900 text-center mt-2"><span class="text-red-600 font-bold">New to Nova? You have it covered</span> <br/> You'll have a full chapter dedicated to the out of the box features + hidden gems that I found out along my Laravel Nova Projects</div>
            </div>

        </div>
    </section>

    <!-- About the Author -->
    <section class="bg-indigo-100 text-black py-8 w-full">
        <div class="w-11/12 sm:w-4/5 hd:w-4/6 flex flex-wrap items-start justify-center mx-auto">
            <div class="w-5/12 sm:w-4/12 lg:w-2/12 hd:w-2/12 flex-shrink-0">
                <img class="rounded-full mx-auto border-4 border-red-500 p-2" src="images/profile-photo.jpg">
            </div>
            <div class="w-full sm:w-8/12 lg:w-10/12 hd:w-10/12 pl-5">
                <h2 class="text-center sm:text-left pb-2 text-3xl font-bold text-indigo-900">Save hundreds of hours hitting your head on Nova</h2>

                <p class="text-sm md:text-md lg:text-xl">Don't waste more time losing hours trying to understand how Nova works, if you buy my course I can guarantee you that you will learn everything from the basic to advanced Resource management, how to structure your Resources and test them, how to build that <i>impossible</i> advanced UI feature, and what are the best Community packages you need on your Nova Web app. You will, indeed, demystify Nova.
                </p>
                <p class="pt-2 text-sm md:text-md lg:text-xl">I am <a class="link-dark" href="https://twitter.com/brunocfalcao" target="_blank">@brunocfalcao</a>, and I am working in Laravel since version 5.x, where I have created Laravel projects such as <a class="link-dark" href="https://www.laraning.com" target="_blank">Laraning</a>, <a class="link-dark" href="https://www.laraflash.com" target="_blank">Laraflash</a>, <a class="link-dark" href="https://github.com/brunocfalcao/larapush" target="_blank">Larapush</a>, <a class="link-dark" href="https://github.com/laraning/nova-time-field" target="_blank">Nova Time Field</a>, <a class="link-dark" href="https://github.com/brunocfalcao/flame" target="_blank">Flame</a> and <a class="link-dark" href="https://github.com/brunocfalcao/blade-feather-icons" target="_blank">Blade UI Feather Icons</a>.</p>
            </div>
        </div>
    </section>

    <!-- Things you will learn in learn on this course -->
    <section class="w-11/12 md:w-5/6 lg:w-3/4 hd:w-1/2 mx-auto py-16">
        <div class="text-center mx-auto">
            <h1 class="font-bold text-2xl md:text-4xl pb-4 text-red-500">Things you will learn on this course</h1>
            <div>
                <ul class="font-bold text-lg text-left">
                    <li class="flex items-center sm:p-4"><x-feathericon-image class="hidden sm:block s-10 md:s-12 text-green-500" /><span class="sm:pl-4 text-lg sm:text-2xl pb-4 sm:pb-0">Build UI components with high UX interoperabilities</span></li>
                    <li class="flex items-center sm:p-4"><x-feathericon-maximize-2 class="hidden sm:block s-10 md:s-12 text-green-500" /><span class="sm:pl-4 text-lg sm:text-2xl pb-4 sm:pb-0">Using Async data behaviors to refresh your UI Features</span></li>
                    <li class="flex items-center sm:p-4"><x-feathericon-code class="hidden sm:block s-10 md:s-12 text-green-500" /><span class="sm:pl-4 text-lg sm:text-2xl pb-4 sm:pb-0">Using Abstract Resource patterns to optimize your Model Resources</span></li>
                    <li class="flex items-center sm:p-4"><x-feathericon-users class="hidden sm:block s-10 md:s-12 text-green-500" /><span class="sm:pl-4 text-lg sm:text-2xl pb-4 sm:pb-0">Creating a Tool end-to-end (Vue structure, Permissions, ...)</span></li>
                    <li class="flex items-center sm:p-4"><x-feathericon-gift class="hidden sm:block s-10 md:s-12 text-green-500" /><span class="sm:pl-4 text-lg sm:text-2xl pb-4 sm:pb-0">How to use all out-of-the-box Nova Components</span></li>
                    <li class="flex items-center sm:p-4"><x-feathericon-package class="hidden sm:block s-10 md:s-12 text-green-500" /><span class="sm:pl-4 text-lg sm:text-2xl pb-4 sm:pb-0">Lots of 3rd party packages integrations</span></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Testimonial Christoph Rumpel -->
    <section class="w-full bg-red-500 py-8">
        <div class="w-11/12 md:w-5/6 lg:w-2/3 xl:w-1/2 flex flex-wrap items-center justify-center mx-auto">
            <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 pb-6 md:pb-0">
                <img src="images/twitter-christoph-rumpel.jpg" class="mx-auto border-4 border-white p-2 rounded-full h-48 w-48">
            </div>
            <div class="text-base lg:text-xl w-full md:w-1/2 lg:w-2/3 text-indigo-100">
            "Been following Bruno Falcao's course process and I'm happy for him for the launch! It's also great to finally have a more in-depth Laravel Nova course. Congrats!"
            <br>
            <p class="pt-2 not-italic"><a class="link-light" href="https://twitter.com/christophrumpel" target="_blank">@christophrumpel</a> - <a class="link-light" href="https://laravelcoreadventures.com/" target="_blank">Laravel Core Adventures Creator</a> on a <a class="link-light" target="_blank" href="https://twitter.com/christophrumpel/status/1312037309227962369">Twitter post</a></p>
            </div>
        </div>
    </section>

    <!-- Full Course Catalog (after launch) -->
    <section class="w-11/12 lg:w-8/12 mx-auto py-16">
        <h1 class="text-center font-bold text-2xl md:text-4xl pb-4 text-red-500">Full Course Catalog</h1>
        @foreach($chapters as $chapter)

        <!-- {{ $chapter->title }} -->
        <div class="flex flex-wrap justify-center items-start">
            <div class="w-full md:w-1/2 text-left p-5">
                <h2 class="text-4xl font-bold text-indigo-100 pb-4">{{ $chapter->title }}</h2>
                <ul>
                    @foreach($chapter->visibleVideos as $video)
                    @if($video->is_active)
                    <a href="{{ route('videos.play', ['video' => $video->id ])}}">
                    @endif
                    <li class="flex items-center p-1">
                        @if($video->is_recorded)
                        <x-feathericon-video class="flex-shrink-0 s-8 text-green-500 mr-2" />
                        <span class="text-lg text-green-200">{{ $video->title }}</span>
                        @else
                        <x-feathericon-video class="flex-shrink-0 s-8 text-gray-500 mr-2" />
                        <span class="text-lg">{{ $video->title }}</span>
                        @endif
                        @if($video->is_free)
                        &nbsp;&nbsp;<div class="bg-red-500 text-white px-2 py-1 text-xs rounded-full">Free</div>
                        @endif
                    </li>
                    @if($video->is_active)
                    </a>
                    @endif
                    @endforeach
                </ul>
                <div class="flex items-center justify-start pt-2">
                    <div><x-bi-collection class="s-8 text-red-500" /></div>
                    <div class="pl-2 font-bold text-red-500">{{ $chapter->videos()->count() }} Videos</div>
                </div>
            </div>
            <div class="w-full sm:w-1/2 p-5">
                <div class="owl-carousel owl-theme rounded rounded-lg border-4 border-red-500">
                    @foreach(optional($chapter)->getMedia() ?? [] as $media)
                    <div class="item p-2"><img class="rounded rounded-lg" src="{{ $media->getUrl('featured') }}"></div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </section>

    <!-- Testimonial - Caneco -->
    <section class="w-full py-8 bg-indigo-100">
        <div class="w-11/12 md:w-5/6 lg:w-2/3 xl:w-1/2 flex flex-wrap items-center justify-center mx-auto">
            <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 pb-6 md:pb-0">
                <img src="https://res.cloudinary.com/caneco/image/upload/e_tint:15:rgb:3f661f,w_160,q_80/v1556227421/me-avatar--code_y0vwf2.jpg" class="mx-auto border-4 p-2 border-red-500 rounded-full h-48 w-48">
            </div>
            <div class="text-base lg:text-xl w-full md:w-1/2 lg:w-2/3 text-indigo-900">
                "If you are trying to code <a class="underline" href="https://twitter.com/search?q=%23laravelnova&amp;src=typed_query" target="_blank">#LaravelNova</a>, it's far more easy to learn from someone that it's rock-coding with Nova since the beginning. Explore the universe of Laravel Nova with @brunocfalcao. Don't be afraid to hit that [Subscribe] button."
                <br>
                <p class="pt-2 not-italic"><a class="link-dark" href="https://twitter.com/Caneco" target="_blank">@Caneco</a> - <a class="link-dark" href="https://laracon.eu/online" target="_blank">Laracon Speaker</a> on a <a class="link-dark" target="_blank" href="https://twitter.com/Caneco/status/1254805571506778113">Twitter post</a></p>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    @guest
    @if(env('LAUNCHED') == 1)
    <section id="pricing" class="hero-pattern-topography py-16">
        <div class="flex justify-center">
            <div class="w-11/12 md:w-2/3 hd:w-1/2">

                @if(WebsiteCheckout::make()->price()->amount->original != WebsiteCheckout::make()->price()->amount->checkout)
                <h2 class="text-3xl font-bold md:text-4xl lg:text-5xl text-center lg:text-left">Get Mastering Nova, for <span class="line-through text-gray-700">$&nbsp;{{ WebsiteCheckout::make()->price()->amount->original }}</span> <span class="text-red-500">$ {{ WebsiteCheckout::make()->price()->amount->checkout }}</span></h2>
                @else
                <h2 class="text-3xl font-bold md:text-4xl lg:text-5xl text-center lg:text-left">Get Mastering Nova, for <span class="text-red-500">$ {{ WebsiteCheckout::make()->price()->amount->original }}</span></h2>
                @endif

                <div class="text-left pt-6">
                    <ul class="font-bold text-lg">

                        @if(WebsiteCheckout::make()->price()->discount->percentage > 0)
                        <li class="flex items-center p-1"><x-feathericon-award class="flex-shrink-0 s-6 text-green-500 mr-2" /><div>Purchase Power Parity Discount of&nbsp;<span class="text-red-500">{{ WebsiteCheckout::make()->price()->discount->percentage }}%</span>&nbsp;since you're coming from&nbsp;<span class="text-red-500">{{ WebsiteCheckout::make()->price()->request->country->name }}</span>!</div></li>
                        @endif

                        @if($videos->where('is_active', true)->get()->count() != $totalVideos)
                        <li class="flex items-center p-1"><x-feathericon-dollar-sign class="flex-shrink-0 s-6 text-red-500 mr-2" />Early Access purchase ({{ $videos->where('is_active', true)->get()->count() }} out of {{ $totalVideos }} videos recorded) with&nbsp;<span class="text-red-500 font-bold">40% discount</span><br/>
                        @endif

                        <li class="flex items-center p-1"><x-feathericon-coffee class="flex-shrink-0 s-6 text-red-500 mr-2" />More than 5 hours of learning lessons, across {{ $videos->count() }} Lessons</li>
                        <li class="flex items-center p-1"><x-feathericon-airplay class="flex-shrink-0 s-6 text-red-500 mr-2" />Instant access view or download all videos</li>
                        <li class="flex items-center p-1"><x-feathericon-folder class="flex-shrink-0 s-6 text-red-500 mr-2" />Additional access to the Nova exercises content</li>
                        <li class="flex items-center p-1"><x-feathericon-check-circle class="flex-shrink-0 s-6 text-red-500 mr-2" />Lifetime updates and access to new material as it's added</li>
                        <li class="flex items-center p-1"><x-feathericon-clipboard class="flex-shrink-0 s-6 text-red-500 mr-2" />Download of Helpdesk Tool for free</li>
                    </ul>
                </div>

                <div class="pt-8 text-center md:text-left">
                    <a href="{{ route('checkout.paylink') }}">
                        <button class="text-xl bg-red-500 p-4 rounded-lg font-bold">Buy the Course Now, instant access, for $ {{ WebsiteCheckout::make()->price()->amount->checkout }}</button>
                    </a>
                    <!--
                    <button class="pt-8 md:pt-0 pl-6 text-gray-500 underline">See Team pricing options</button>
                    -->
                </div>
                <div class="pt-2 text-center md:text-left">
                    Price excludes VAT, if applicable
                </div>
            </div>
        </div>
    </section>
    @endif
    @endguest

    <!-- Testimonial - Patrick Brouwers -->
    <section class="w-full py-8 bg-indigo-900 mb-16">
        <div class="w-11/12 md:w-5/6 lg:w-2/3 xl:w-1/2 flex flex-wrap items-center justify-center mx-auto">
            <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 pb-6 md:pb-0">
                <img src="{{ url('images/twitter-patrick-brouwers.jpg') }}" class="mx-auto border-4 p-2 border-indigo-100 rounded-full h-48 w-48">
            </div>
            <div class="text-base lg:text-xl w-full md:w-1/2 lg:w-2/3 text-indigo-100">
                "If you wanna get the most out of Laravel Nova, have a look at Bruno Falcao's new course!"
                <br>
                <p class="pt-2 not-italic"><a class="link-dark" href="https://twitter.com/patrickbrouwers" target="_blank">@patrickbrouwers</a> - <a class="link-dark" href="https://laravel-excel.com/" target="_blank">Laravel Excel Creator</a> on a <a class="link-dark" target="_blank" href="https://twitter.com/patrickbrouwers/status/1312081581469839360">Twitter post</a></p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="w-full bg-white py-16">

        <div class="flex justify-center">
            <div class="w-11/12 lg:w-2/3">
                <h2 class="text-2xl text-center lg:text-left font-bold lg:text-5xl text-indigo-900">Frequently Asked Questions</h2>
                <!-- Line 1 -->
                <div class="flex flex-wrap text-indigo-900 pt-8">
                    <div class="w-full md:w-1/2">
                        <h1 class="font-bold text-xl text-red-600">Do I need to have experience on Nova before I take this Course?</h1>
                        <p class="text-lg text-indigo-900 pt-2">Not at all. I cover the basics and then move into advanced areas further. I recommend you watch the videos in the recommended order.</p>
                    </div>
                    <div class="w-full md:w-1/2 pt-8 md:pt-0">
                        <h1 class="font-bold text-xl text-red-600">Can I see some of your videos before buying?</h1>
                        <p class="text-lg text-indigo-900 pt-2">Yes, I do post free videos per Chapter, so you can have an idea about the content quality. Feel free to click on the "watch videos" and see the free ones to get an idea about what is waiting for you :)</p>
                    </div>
                </div>
                <!-- Line 2 -->
                <div class="flex flex-wrap text-indigo-900 pt-8">
                    <div class="w-full md:w-1/2">
                        <h1 class="font-bold text-xl text-red-600">Can I pay with Paypal?</h1>
                        <p class="text-lg text-indigo-900 pt-2">Sure! I use Paddle and they support tons of payment methods including Paypal.</p>
                    </div>
                    <div class="w-full md:w-1/2 pt-8 md:pt-0">
                        <h1 class="font-bold text-xl text-red-600">Can I order a refund?</h1>
                        <p class="text-lg text-indigo-900 pt-2">Absolutely. No questions asked. I only want you to pay if you see it's valuable for you.</p>
                    </div>
                </div>
                <!-- Line 3 -->
                <div class="flex flex-wrap text-indigo-900 pt-8">
                    <div class="w-full md:w-1/2">
                        <h1 class="font-bold text-xl text-red-600">Is it VAT included?</h1>
                        <p class="text-lg text-indigo-900 pt-2">No, it's VAT excluded. As soon as you select your country the VAT will be applied.</p>
                    </div>
                    <div class="w-full md:w-1/2 pt-8 md:pt-0">
                        <h1 class="font-bold text-xl text-red-600">Do you use purchase power parity?</h1>
                        @if(env('LAUNCHED') == 1)
                        <p class="text-lg text-indigo-900 pt-2">In case you want a discount based on your country, <a class="link-dark" href="{{ route('welcome.ppp') }}">click here.</a></p>
                        @else
                        <p class="text-lg text-indigo-900 pt-2">Indeed! When I launch the course you will be able to apply for a discount based on your country!</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@vite('resources/js/owl.carousel.js')

<!-- jQuery dom init -->
<script type="text/javascript">
    $(document).ready(function(){
        // Header owl carousel
        $('.owl-carousel').owlCarousel({
            items:1,
            loop:true,
            autoplay:true,
            autoplayTimeout:4000,
            autoplayHoverPause:true,
            slideTransition: "ease",
            smartSpeed: 500
        });
    });
</script>
@paddle
@if(config('app.env') == 'production')
<!-- Twitter universal website tag code -->
<script>
!function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);
},s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='//static.ads-twitter.com/uwt.js',
a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');
// Insert Twitter Pixel ID and Standard Event data below
twq('init','o4qy4');
twq('track','PageView');
</script>
<!-- End Twitter universal website tag code -->
@endif
@endpush

@push('head')
<!-- 3rd party styles -->
<link href="css/owl.carousel.css" rel="stylesheet">
@endpush