@extends('layouts.default', ['navbar' => false, 'footer' => false])

@section('body')

    <section class="hero-pattern-topography h-screen w-full flex justify-center items-center">
        <!-- Header -->
        <div class="w-11/12 lg:w-1/3 text-center">
            <h1 class="text-6xl text-white mx-auto">Course purchased</h1>
            <p class="pt-6 text-xl">Thank you for buying my course!</p>
            <p class="pt-6 text-2xl text-red-500 font-bold">Last Step!</p>
            <p class="pt-6 text-xl">Go to your email. I have sent you a link to reset your password.</p>
            <p class="pt-6 text-xl">Didn't received it? Check your spam or contact me at bruno@masteringnova.com.</p>
            <p class="pt-6 text-xl">Thank you!<br/>Bruno Falcao</p>
        </div>
    </section>

@endsection