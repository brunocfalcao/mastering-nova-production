@extends('layouts.default', ['navbar' => true, 'footer' => false])

@section('body')

    <section class="hero-pattern-topography w-full flex justify-center items-center">
        <!-- Header -->
        <div class="w-11/12 lg:w-1/2">
            <h1 class="text-6xl text-white mx-auto text-center">2 Times Purchase</h1>
            <p class="pt-6 text-xl">I am offering the option for you to buy my course in 2 times. Before you go, let us agree on:</p>
            <p class="pt-6 text-xl text-red-500 flex items-center">
                <x-feathericon-dollar-sign class="sm:block s-6 text-green-500" />
                <span class="text-indigo-100 pl-2">Awesome option if you can't spend the full amount in one go</span>
            </p>
            <p class="pt-6 text-xl text-red-500 flex items-center">
                <x-feathericon-heart class="sm:block s-6 text-green-500" />
                <span class="text-indigo-100 pl-2">I am not charging you any extra comissions or whatsoever</span>
            </p>
            <p class="pt-6 text-xl text-red-500 flex items-center">
                <x-feathericon-credit-card class="sm:block s-6 text-green-500" />
                <span class="text-indigo-100 pl-2">You can apply a coupon now, but not on your 2nd payment</span>
            </p>
            <p class="pt-6 text-xl text-red-500 flex items-center">
                <x-feathericon-clock class="sm:block s-6 text-green-500" />
                <span class="text-indigo-100 pl-2">2nd payment will be settled on <span class="text-red-500">{{ \Carbon\Carbon::now()->addMonth()->toDateString() }} 5PM UTC</span></span>
            </p>
            <p class="pt-6 text-xl text-red-500 flex items-center">
                <x-feathericon-alert-circle class="sm:block s-6 text-green-500" />
                <span class="text-indigo-100 pl-2">You cannot ask for a reimbursement until you pay full</span>
            </p>
            <p class="pt-6 text-xl text-red-500 flex items-center">
                <x-feathericon-mail class="sm:block s-6 text-green-500" />
                <span class="text-indigo-100 pl-2">You'll receive an email on the date of the 2nd payment with a payment link</span>
            </p>
            <p class="pt-6 text-xl text-red-500 flex items-center">
                <x-feathericon-user-x class="sm:block s-6 text-green-500" />
                <span class="text-indigo-100 pl-2">If you don't pay after that date, then after 3 days your account is disabled (until you pay)</span>
            </p>
            <div class="w-full text-center pt-4 flex justify-center">
                <a class="w-full sm:w-auto" href="{{ route('checkout.paylink.half') }}" target='_self'>
                    <button class="h-20 w-full p-5 text-base sm:text-2xl font-bold bg-indigo-100 text-indigo-900 rounded rounded-lg flex items-center justify-center sm:justify-start sm:mr-4 hover:bg-white hover:text-red-500">
                        <x-feathericon-thumbs-up class="block hidden hd:block s-8 mr-4" />
                        <div class="text-left text-base md:text-2xl lg:text-xl lg:font-bold">
                            Pay half now&nbsp;<span class="line-through text-gray-500">$ {{ WebsiteCheckout::make()->price()->amount->default }}</span> $ {{ WebsiteCheckout::make()->price()->amount->half }}
                        </div>
                    </button>
                </a>
            </div>
            <p class="pt-1 text-center mx-auto block text-sm text-white">Price excludes VAT, if applicable</p>
        </div>
    </section>
@endsection