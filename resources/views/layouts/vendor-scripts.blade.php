<!-- JS Scripts -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ url('assets/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ url('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
<script src="{{ url('assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
<script src="{{ url('assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ url('assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
<script src="{{ url('assets/js/jquery.cookie.js') }}"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ url('assets/js/off-canvas.js') }}"></script>
<script src="{{ url('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ url('assets/js/misc.js') }}"></script>
<script src="{{ url('assets/js/settings.js') }}"></script>
<script src="{{ url('assets/js/todolist.js') }}"></script>
<!-- endinject -->

@yield('script')
<script>
    //On Dom ready
    $(document).ready(function () {

    });
</script>