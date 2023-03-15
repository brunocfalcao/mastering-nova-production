@extends('layouts.default', ['navbar' => false, 'footer' => false])

@section('body')

    <section class="hero-pattern-topography h-screen flex justify-center items-center">

        <div class="w-11/12 lg:w-1/3 text-center">
            <img class="w-1/5 mx-auto" src="/images/logo-navbar-white.png" />
            @routename('giveaway.newsletter.form')
                @twinkle('form')
            @else
                @twinkle('subscribe')
            @endroutename
        </div>

    </section>

@endsection