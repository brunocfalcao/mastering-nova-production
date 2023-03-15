<h1 class="pt-4 text-4xl font-bold text-red-500">Giveaway Contest - 1 Free Course</h1>
<p class="font-bold">End of Contest: 23rd October Midnight UTC</p>

<form method="post" action="{{ route('giveaway.newsletter.subscribe') }}">
    @csrf
    @honeypot
    <div class="pt-4">
        <input class="p-5 rounded bg-black border-red-500 border-2 w-full placeholder-white placeholder-opacity-100" type="text" name="email" placeholder="Enter your email to join the Giveaway Contest" autofocus />
    </div>
    @error('email')
        <div class="pt-1 text-red-500 font-bold text-left">{{ $message }}</div>
    @enderror
    <div class="flex items-center justify-start pt-1">
        <p class="pl-1 pt-1 text-sm text-white">Your email will <u>never</u> be shared with 3rd parties or be used for spam</p>
    </div>
    <input class="cursor-pointer hover:text-red-800 hover:bg-red-200 hover:border-red-200 block mx-auto w-1/3 p-3 bg-red-500 text-white mt-6 rounded border-2 border-red-500" type="submit" value="Join Contest!" />
</form>
