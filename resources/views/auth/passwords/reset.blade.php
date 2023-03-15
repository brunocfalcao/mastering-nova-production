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

        <!-- Login form -->
        <form class="w-full p-6" method="POST" action="{{ route('password.update') }}">
            @csrf
            @honeypot

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            @if($name == null)
            <!-- Name field -->
            <div class="mb-8">
                <label class="font-bold pl-2">Name</label>
                <div class="rounded bg-white border border-indigo-900 p-2 flex items-center">
                    <x-heroicon-o-key class="text-gray-500 s-8 pr-2" />
                    <input class="w-full placeholder-gray-500" name="name" type="text" placeholder="Doug Hurley" value="{{ $name ?? old('name') }}" />
                </div>
                @error('name')
                    <div class="pt-2 text-xs text-red-700 font-bold text-left">{{ $message }}</div>
                @enderror
            </div>
            @endif

            <!-- Password field -->
            <div class="mb-8">
                <label class="font-bold pl-2">Password</label>
                <div class="rounded bg-white border border-indigo-900 p-2 flex items-center">
                    <x-heroicon-o-key class="text-gray-500 s-8 pr-2" />
                    <input class="w-full placeholder-gray-500" name="password" type="password" placeholder="Dragon9#!" />
                </div>
                @error('password')
                    <div class="pt-2 text-xs text-red-700 font-bold text-left">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password field -->
            <div class="mb-8">
                <label class="font-bold pl-2">Confirm Password</label>
                <div class="rounded bg-white border border-indigo-900 p-2 flex items-center">
                    <x-heroicon-o-key class="text-gray-500 s-8 pr-2" />
                    <input class="w-full placeholder-gray-500" name="password_confirmation" type="password" />
                </div>
                @error('password')
                    <div class="pt-2 text-xs text-red-700 font-bold text-left">{{ $message }}</div>
                @enderror
            </div>

            <!-- Reset password button -->
            <div class="w-2/3 mx-auto">
                <button class="button-dark" type="submit">Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection