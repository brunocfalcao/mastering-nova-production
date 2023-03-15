@extends('layouts.default', ['bodyClass' => 'auth', 'navbar' => false, 'footer' => false])

@section('body')
<!-- Main centered container -->
<div class="w-full mx-auto h-screen flex justify-center items-center">

    <!-- Login container -->
    <div class="w-11/12 md:w-1/2 xl:w-2/4 hd:w-1/4 bg-indigo-100 rounded rounded-lg p-8 relative login-box">

        <!-- Content top label -->
        <div class="bg-red-500 w-48 py-2 mx-auto -mt-8 rounded-b-lg">
            <h3 class="text-white text-center font-bold tracking-wider">Reset Password</h3>
        </div>

        <!-- Centered logo and title -->
        <div class="pt-10 pb-6">
            <div class="w-1/2 mx-auto">
                <img class="mx-auto h-10" src="/images/logo-navbar-dark.png">
            </div>
            <h4 class="text-center mt-4 font-bold text-xl">Mastering Nova</h4>
        </div>

        @if(session('status'))
        <div class="text-center mb-6">A link was sent to your inbox. Please check also your spam folder, just in case.</div>
        @else
        <!-- Instructions -->
        <div class="mb-6 w-4/5 mx-auto text-sm text-gray-600 text-center">Please enter your <strong>purchase email</strong> to receive your password reset link.<br/>Issues to remember? Just <a class="link-dark" target="_blank" href="mailto:bruno@masteringnova.com">contact me!</a></div>

        <!-- Login form -->
        <form method="POST" action="{{ route('password.email') }}">
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

            <!-- Reset password button -->
            <div class="mb-6 w-2/3 mx-auto">
                <button class="button-dark" type="submit">Send Reset Link</button>
            </div>
        </form>
        @endif

        <!-- Back to login link -->
        <div class="text-xs text-gray-500 text-center"><a class="link-dark" href="{{ route('login') }}">Back to Login</a></div>
    </div>
</div>
@endsection