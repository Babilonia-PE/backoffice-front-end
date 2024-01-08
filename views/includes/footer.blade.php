<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2023-{{ date("Y") }} <a href="https://babilonia.io">Babilonia.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> {{ env('VERSION') }}
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
{{-- <script src="@asset("plugins/jquery/jquery.min.js")"></script> --}}
<script src="@asset("plugins/jquery/jquery.3.4.1.min.js")"></script>
<!-- jQuery UI 1.11.4 -->
<script src="@asset("plugins/jquery-ui/jquery-ui.min.js")"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="@asset("plugins/bootstrap/js/bootstrap.bundle.min.js")"></script>
<!-- ChartJS -->
<script src="@asset("plugins/chart.js/Chart.min.js")"></script>

<!-- Sparkline -->
<script>
  window.currentPage = "{{ $currentPage }}";
  const URL_WEB_FRONT = "{{ env('URL_WEB_FRONT', 'https://www-testing.babilonia.io/') }}";
</script>
@if($currentPage == "home")

<script src="@asset("plugins/sparklines/sparkline.js")"></script>

<!-- JQVMap -->
{{-- <script src="@asset("plugins/jqvmap/jquery.vmap.min.js")"></script> --}}
{{-- <script src="@asset("plugins/jqvmap/maps/jquery.vmap.usa.js")"></script> --}}
<script src="@asset("plugins/jqvmap/jquery-jvectormap-2.0.5.min.js")"></script>
<script src="@asset("plugins/jqvmap/jquery-vectormap.peru.js")"></script>

@endif
<!-- Bootstrap select -->
<script src="@asset("plugins/bootstrap-select/js/bootstrap-select.min.js")"></script>
<!-- jQuery Knob Chart -->
<script src="@asset("plugins/jquery-knob/jquery.knob.min.js")"></script>
<!-- daterangepicker -->
<script src="@asset("plugins/moment/moment.min.js")"></script>
<script src="@asset("plugins/daterangepicker/daterangepicker.js")"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="@asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")"></script>
<!-- Summernote -->
<script src="@asset("plugins/summernote/summernote-bs4.min.js")"></script>
<!-- overlayScrollbars -->
<script src="@asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")"></script>
<!-- AdminLTE App -->
<script src="@asset("js/adminlte.js")"></script>
<!-- AdminLTE for demo purposes -->
<script src="@asset("js/demo.js")"></script>
@if($currentPage == "home")
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="@asset("js/pages/dashboard.js")"></script>
@endif
<script src="@asset("js/inputmask.min.js")"></script>
<script src="@asset("js/axios.min.js")"></script>
<script src="@asset("js/app.js")"></script>
@yield("scripts")
@stack('child-scripts')

</body>
</html>
