<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body class="{{ $bodyClass ?? 'welcome' }}">

        {{--
        @include('utils.debug')
        @include('utils.outline')
        @include('utils.ruler')
        --}}

        <div class="mx-auto">
        @if(($navbar ?? true) != false)
            @include('layouts.partials.navbar')
            <div class="pt-32 sm:pt-24">
        @else
            <div>
        @endif

        @yield('body')
            </div>
        </div>

        @auth
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            {{ csrf_field() }}
        </form>
        @endauth

        @if(($footer ?? true) != false)
            @include('layouts.partials.footer')
        @endif

        @include('layouts.partials.scripts')
    </body>
</html>