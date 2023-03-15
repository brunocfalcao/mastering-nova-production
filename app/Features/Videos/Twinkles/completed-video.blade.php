<a href="{{ route('videos.play', ['video' => $video->id ]) }}" title="{{ $video->title }}">
    <div class="flex items-center justify-between pb-2 text-indigo-900">

        <div class="flex items-center">
            <x-feathericon-check class="s-4 mx-2" />
            <p>{{ $video->title }}{!! $video->is_free == true && Auth::guest() ? " <span class='px-2 py-1 rounded-lg bg-red-500 text-white text-xs font-normal'>free</span>" : ""  !!}</p>
        </div>
        <div class="hidden lg:block text-sm">{{ $video->duration }}</div>
    </div>
</a>