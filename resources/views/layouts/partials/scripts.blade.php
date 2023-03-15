<!-- Main app scripts -->
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

<!-- jQuery dom init -->
<script type="text/javascript">

    function toggleLateralVideosNavbar(){
        $("#lateralVideosNavbar").toggle();
    }

</script>

<!-- Additional scripts -->
@stack('scripts')
