<!-- Main app scripts -->
@vite('resources/js/app.js')

<!-- jQuery dom init -->
<script type="text/javascript">

    function toggleLateralVideosNavbar(){
        $("#lateralVideosNavbar").toggle();
    }

</script>

<!-- Additional scripts -->
@stack('scripts')
