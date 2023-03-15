<!-- Navbar + Header full width container -->
<!-- Navbar -->
<nav class="fixed z-50 w-full bg-indigo-900">
    <div class="w-11/12 lg:w-10/12 flex flex-wrap mx-auto items-center justify-between px-1 py-2 md:px-5 md:py-3">
        <!-- Logo -->
        <div class="hidden lg:block md:pl-5 lg:w-1/3">
            <a class="hover:cursor-pointer" target="_self" href="{{ route('welcome') }}"><img class="h-10" src="/images/logo-navbar-white.png" /></a>
        </div>

        @if(optional($navbar_links ?? null) == true)

        @guest
        <div class="w-full text-center sm:w-1/2 lg:w-1/3 py-1">
            <div class="text-sm py-1 {{ app()->environment() == 'staging' ? 'bg-red-500' : 'bg-yellow-500' }} rounded rounded-lg text-indigo-900 font-bold">Get 50% discount now and don't pay more for the next Nova version</div>
        </div>
        @endguest

        <!-- Links -->
        <div class="sm:w-1/2 lg:w-1/3 mx-auto sm:m-0 sm:text-right sm:m-0 xl:pr-20 font-bold py-1">
            @guest
                @if(env('LAUNCHED') == 1)
                <a href="{{ WebsiteCheckout::make()->payLink() }}">
                    <button class="bg-red-500 rounded rounded-lg font-bold text-white py-2 px-4">Buy Now</button>
                </a>
                @endif
            @endguest

            @auth
            @routename('welcome')
            <a class="pl-4" href="{{ route('videos') }}">Watch Videos</a>
            @endroutename

            @if(Gravatar::exists(Auth::user()->email))
            <img class="hidden sm:inline s-8 rounded-full" src="{{ Gravatar::src(Auth::user()->email) }}">
            @endif
            <a class="pl-4" href="{{ Auth::user()->invoice_link ?? '/#' }}" target="_blank">Invoice</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="pl-4" href="{{ route('login') }}">Logout</a>
            @endauth

            @guest
            @if(env('LAUNCHED') == 1)
            <a class="pl-4 link-dark-no-underline" href="{{ route('login') }}">Login</a>
            @endif
            @endguest

            <a class="pl-4 link-dark-no-underline" href="mailto:bruno@masteringnova.com">Contact</a>

            @routename('videos')
            <a class="md:hidden pl-4 link-dark-no-underline" href="#" onclick="javascript:toggleLateralVideosNavbar();">Videos</a>
            @endroutename

            @routename('videos.play')
            <a class="md:hidden pl-4 link-dark-no-underline" href="#" onclick="javascript:toggleLateralVideosNavbar();">Videos</a>
            @endroutename
        </div>
        @endif
    </div>
</nav>

@if(isset($chapters))
<div id="lateralVideosNavbar" class="absolute inset-0 w-64 z-100 bg-white hidden pt-2 pl-2 overflow-auto">
    @foreach($chapters as $chapter)
    <ul class="text-indigo-900">
        <h3 class="text-red-500 font-bold">{{ $chapter->title }}</h3>
        @foreach($chapter->videos as $video)

            @if($video->is_visible)
                {{-- Can the video be played ? --}}
                @can('play-video', $video)
                    <li class="text-sm pb-2"><a href="{{ route('videos.play', ['video' => $video->id ]) }}">{{ $video->title }}</a></li>
                @endcan

            @endif

        @endforeach
    </ul>
    @endforeach
</div>
@endif