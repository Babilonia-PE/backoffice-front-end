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
<script src="{{ secure_asset("plugins/jquery/jquery.min.js") }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ secure_asset("plugins/jquery-ui/jquery-ui.min.js") }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ secure_asset("plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<!-- ChartJS -->
<script src="{{ secure_asset("plugins/chart.js/Chart.min.js") }}"></script>
<!-- Sparkline -->
<script src="{{ secure_asset("plugins/sparklines/sparkline.js") }}"></script>
<!-- JQVMap -->
<script src="{{ secure_asset("plugins/jqvmap/jquery.vmap.min.js") }}"></script>
<script src="{{ secure_asset("plugins/jqvmap/maps/jquery.vmap.usa.js") }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ secure_asset("plugins/jquery-knob/jquery.knob.min.js") }}"></script>
<!-- daterangepicker -->
<script src="{{ secure_asset("plugins/moment/moment.min.js") }}"></script>
<script src="{{ secure_asset("plugins/daterangepicker/daterangepicker.js") }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ secure_asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
<!-- Summernote -->
<script src="{{ secure_asset("plugins/summernote/summernote-bs4.min.js") }}"></script>
<!-- overlayScrollbars -->
<script src="{{ secure_asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ secure_asset("assets/js/adminlte.js") }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ secure_asset("assets/js/demo.js") }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ secure_asset("assets/js/pages/dashboard.js") }}"></script>

@yield("scripts")

</body>
</html>
