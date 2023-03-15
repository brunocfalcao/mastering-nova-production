@extends('layouts.default')

@section('body')

    <!-- Main responsive container viewport -->
    <div class="mx-auto w-full px-4 mb-10">

        <!-- Video + chapter list columns -->
        <section>
            <div class="flex">
                <!-- Video container (for sizing computations) -->
                <div class="w-full md:w-4/6 xl:w-3/5 hd:w-4/6 p-2 border-4 rounded-lg border-red-600">
                    <!-- Video inner component (screen + buttons) -->
                    <div id="video-player">

                        <!-- Video screen -->
                        <iframe id="video-frame" title="lesson player" src="https://player.vimeo.com/video/{{ $playable->vimeo_id }}" width="100%" height="56%" frameborder="0" allowfullscreen></iframe>

                        <!-- Video buttons -->
                        <div id="video-buttons" class="mt-2 flex items-center {{ $playable->previous()->exists() ? 'justify-between' : 'justify-end' }} h-12">

                            @if($playable->previous)
                            <!-- Previous -->
                            <a href="{{ route('videos.play', ['video' => $playable->previous->id]) }}">
                                <div class="flex flex-shrink-0 h-full items-center justify-center bg-red-500 rounded-bl-lg text-white h-full p-2 text-sm font-bold w-32">
                                    <x-feathericon-arrow-left-circle class="s-5" />
                                    <span class="hidden sm:block pl-2 text-base">
                                    Previous
                                    </span>
                                </div>
                            </a>
                            @endif

                            @isset($playable->filename)
                            <div class="flex justify-end items-center">
                                <!-- Bookmark Download -->
                                <div class="flex h-full pl-2">
                                    @auth
                                    <a  href="{{ URL::temporarySignedRoute('videos.download', now()->addMinutes(60), ['video' => $playable->id ]) }}" target="_blank">
                                    <div class="flex items-center justify-center bg-red-500 text-white h-full p-2 text-sm font-bold w-12 sm:w-auto">
                                        <x-feathericon-download-cloud class="s-5" />
                                        <span class="hidden sm:block pl-2 text-base">
                                        Download
                                        </span>
                                    </div>
                                    </a>
                                    @endauth
                                </div>
                                @endisset

                                <!-- Bookmark + Next -->
                                <div class="flex h-full pl-2">
                                    @auth
                                    <a  onclick="event.preventDefault(); document.getElementById('video-completed').submit();"  href="{{ route('videos.completed', ['video' => $playable->id]) }}" target="_self">
                                    <div class="flex items-center justify-center bg-red-500 text-white h-full p-2 text-sm font-bold w-12 sm:w-auto mr-2">
                                        <x-feathericon-check-square class="s-5" />
                                        <span class="hidden sm:block pl-2 text-base">
                                        Mark as completed
                                        </span>
                                    </div>
                                    </a>
                                    @endauth
                                    @if($playable->next)
                                    <a href="{{ route('videos.play', ['video' => $playable->next->id]) }}" target="_self">
                                        <div class="flex flex-shrink-0 items-center justify-center bg-red-500 rounded-br-lg text-white h-full p-2 text-sm font-bold w-32">
                                            <x-feathericon-arrow-right-circle class="s-5" />
                                            <span class="hidden sm:block pl-2 text-base">
                                            Next
                                            </span>
                                        </div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chapter list container -->
                <div class="hidden md:block md:w-2/6 xl:w-2/5 hd:w-2/6 self-stretch pl-6">

                    <div class="flex flex-col justify-end bg-white rounded-lg px-4 pb-4">

                        <div id="course-content-header">
                            <h1 class="font-bold text-2xl pt-3 text-indigo-900">Course Content</h1>
                            <div class="mt-2 h-1 w-full bg-indigo-900"></div>
                        </div>

                        <!-- Chapter list -->
                        <div id="chapters-container" class="relative overflow-hidden pr-4">

                            @foreach($chapters as $chapter)
                            <!-- {{ $chapter->title }} branch -->
                                <div class="tree-branch mt-4">

                                    <!-- Chapter Head -->
                                    <a href="#" title="Click to expand / collapse the chapter lessons">
                                    <div class="chapter-section p-4 flex items-center justify-between text-red-900 bg-indigo-900 rounded-xl rounded">
                                        <div>
                                            <h2 class="font-bold text-lg lg:text-xl text-white">{{ $chapter->title }}</h2>
                                            <div class="hidden text-gray-500 text-xs lg:flex items-center">
                                            <x-feathericon-clock class="s-4 mr-2" /><span>{{ $chapter->total_minutes }} minutes</span>
                                            <x-feathericon-video class="s-4 mx-2" /><span>{{ $chapter->total_videos }} Lessons</span>
                                            <x-feathericon-check-circle class="s-4 mx-2" /><span>{{ $chapter->videos_completed->count() }} Completed</span>
                                            </div>
                                        </div>
                                        <x-feathericon-chevron-up class="chevron-up cursor-pointer tree-branch-toggle text-white s-5" />
                                        <x-feathericon-chevron-down class="chevron-down hidden cursor-pointer tree-branch-toggle text-white s-5" />
                                    </div>
                                    </a>

                                    <div class="branch-children bg-indigo-100 pt-4 px-2 rounded-b-lg">

                                        @foreach($chapter->videos as $video)

                                            {{-- Can the video appear ? --}}
                                            @if($video->is_visible)

                                                {{-- Can the video be played ? --}}
                                                @can('play-video', $video)

                                                    {{-- Is the video currently being played ? --}}
                                                    @if($playable->id == $video->id)
                                                        @twinkle('playing-video', ['video' => $video])
                                                    @else

                                                        {{-- Was the video completed ? --}}
                                                        @if($video->is_completed)
                                                            @twinkle('completed-video', ['video'=> $video])
                                                        @else
                                                            {{-- Can I have the video available ? --}}
                                                            @twinkle('available-video', ['video'=> $video])
                                                        @endif
                                                    @endif
                                                @else
                                                    @twinkle('disabled-video', ['video' => $video])
                                                @endcan
                                            @endif

                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-6">
            <div class="flex flex-wrap">

                <!-- Video details -->
                <div class="w-full md:w-4/6 text-4xl text-white">
                    <p class="text-4xl">{{ $playable->title }}</p>
                    <p class="text-xl pt-6">{{ $playable->details }}</p>
                </div>

                <!-- Lesson Resources -->
                <div class="w-full md:w-2/6 md:pl-6 mt-4 md:mt-0">
                    <p class="text-2xl text-white font-bold">Lesson Resources</p>
                    <ul class="mt-2">
                        @foreach($playable->links()->get() as $link)
                        <li>
                            <div class="flex items-center">
                                <x-feathericon-link class="text-red-500 s-6" />
                                <p class="text-base pl-2"><a href="{{ $link->url }}" target="_blank">{{ $link->title }}</a></p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
        </section>
    </div>

    <form id="video-completed" action="{{ route('videos.completed', ['video' => $playable->id]) }}" method="POST" style="display: none;">
        @csrf
    </form>

@endsection

@push('head')
<link href="{{ mix('css/perfect-scrollbar.css') }}" rel="stylesheet">
@endpush

@push('scripts')

<!-- https://github.com/rosszurowski/fitvids -->
<script src="{{ mix('/js/fitvids.js') }}"></script>

<!-- https://github.com/mdbootstrap/perfect-scrollbar -->
<script src="{{ mix('/js/perfect-scrollbar.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function(){
        // Make video player responsive and 6:9.
        $( "#video-player" ).fitVids();

        // Update perfect scroll in case of viewport resize.
        $( window ).resize(function() {
            $("#chapters-container").css('height', $("#video-frame").outerHeight() - $("#course-content-header").outerHeight() + $("#video-buttons").outerHeight() + 15);
            ps.update();
        });

        // Align heights of both video and chapters containers. Maybe one day this approach will be improved. But not today! :)
        $("#chapters-container").css('height', $("#video-frame").outerHeight() - $("#course-content-header").outerHeight() + $("#video-buttons").outerHeight() + 15);

        // tree-branch-toggle behavior.
        $(".chapter-section").click(function() {
            $(this).closest('.tree-branch').find('.branch-children').slideToggle(100);
            $(this).closest('.tree-branch').find('.chevron-up').toggle();
            $(this).closest('.tree-branch').find('.chevron-down').toggle();
        });

        // Collapse all branches behavior.
        $(".tree-branch-toggle").each(function(){
            $(this).closest('.tree-branch').find('.branch-children').hide();
            $(this).closest('.tree-branch').find('.chevron-up').show();
            $(this).closest('.tree-branch').find('.chevron-down').hide();
        })

        // Expand the chapter branch that has the video linked to it.
        $(".playing").closest(".tree-branch").find('.branch-children').show();
        $(".playing").closest('.tree-branch').find('.chevron-up').hide();
        $(".playing").closest('.tree-branch').find('.chevron-down').show();
    });

    const container = document.querySelector('#chapters-container');
    const ps = new PerfectScrollbar(container, {
        wheelSpeed: 0.3,
        wheelPropagation: false,
        suppressScrollX: true,
        minScrollbarLength: 5
    });

    function toggleChapter(branch){
        alert(branch);
    }
</script>
@endpush