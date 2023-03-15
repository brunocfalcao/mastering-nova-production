@extends('layouts.default', ['bodyClass' => 'auth', 'navbar' => false, 'footer' => false])

@section('body')
<!-- Main centered container -->
<div class="w-full mx-auto h-screen flex justify-center items-center">

    <!-- Login container -->
    <div class="w-11/12 md:w-1/2 xl:w-2/4 hd:w-1/4 bg-indigo-100 rounded rounded-lg p-8 relative login-box">

        <!-- Content top label -->
        <div class="bg-indigo-900 w-32 py-2 mx-auto -mt-8 rounded-b-lg">
            <h3 class="text-white text-center font-bold tracking-wider">Login</h3>
        </div>

        <!-- Centered logo and title -->
        <div class="pt-10 pb-6">
            <div class="w-1/2 mx-auto">
                <img class="mx-auto h-10" src="/images/logo-navbar-dark.png">
            </div>
            <h4 class="text-center mt-4 font-bold text-xl">Mastering Nova</h4>
        </div>

        <!-- Instructions -->
        <div class="mb-6 mx-auto text-sm text-gray-600 text-center">Please login with your registered email and password credentials, or make a <a class="font-bold link-dark" href="{{ route('password.request') }}">password reset</a></div>

        <!-- Login form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            @honeypot
            <!-- Email field -->
            <div class="mb-8">
                <label class="font-bold pl-2">Email</label>
                <div class="rounded bg-white border border-indigo-900 p-2 flex items-center">
                    <x-heroicon-o-mail class="text-gray-500 s-8 pr-2" />
                    <input class="w-full placeholder-gray-500" name="email" type="text" placeholder="doug@nasa.gov" autofocus />
                </div>
                @error('email')
                    <div class="pt-2 text-xs text-red-700 font-bold text-left">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password field -->
            <div class="mb-1">
                <label class="font-bold pl-2">Password</label>
                <div class="rounded bg-white border border-indigo-900 p-2 flex items-center">
                    <x-heroicon-o-key class="text-gray-500 s-8 pr-2" />
                    <input class="w-full placeholder-gray-500" name="password" type="password" placeholder="Dragon9#!" />
                </div>
                @error('password')
                    <div class="pt-2 text-xs text-red-700 font-bold text-left">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember me and forgot password -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <input type="checkbox" name="remember" id="remember" class="form-checkbox border border-indigo-900 cursor-pointer text-indigo-900">
                    <div class="text-xs text-gray-800 inline-block pl-1">Remember me</div>
                </div>
                <div>
                    <div class="text-xs text-gray-800 inline-block pl-2 font-bold"><a class="link-dark" href="{{ route('password.request') }}">Forgot password?</a></div>
                </div>
            </div>

            <!-- Login button -->
            <div class="mb-6 w-2/3 mx-auto">
                <button class="button-dark hvr-underline-reveal" type="submit">Get on-board</button>
            </div>

            <!-- Don't have account ? -->
            <div class="text-xs text-gray-500 text-center">Don't have an account? Please <a class="link-dark font-bold" href="{{ route('checkout.paylink') }}">buy the course</a></div>
        </form>

    </div>
</div>
@endsection