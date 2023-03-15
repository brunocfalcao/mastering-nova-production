<a title="You can watch it after buying the course">
    <div class="flex items-center justify-between pb-2 text-gray-500">
        <div class="flex items-center">
            <x-feathericon-video class="s-4 mx-2" />
            <p>{{ $video->title }}</p>
        </div>
        <div class="hidden lg:block text-sm">{{ $video->duration }}</div>
    </div>
</a>