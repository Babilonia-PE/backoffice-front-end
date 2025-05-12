<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2023-{{ date("Y") }} <a target="_blank" href="{{ env('URL_WEB_FRONT', 'https:/babilonia.io') }}">Babilonia.io</a>.</strong>
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
{{-- <script src="@asset('public/plugins/jquery/jquery.min.js')?{{env('APP_JS_VERSION')}}"></script> --}}
<script src="@asset('public/plugins/jquery/jquery.3.4.1.min.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="@asset('public/plugins/jquery-ui/jquery-ui.min.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="@asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- ChartJS -->
<script src="@asset('public/plugins/chart.js/Chart.min.js')?{{env('APP_JS_VERSION')}}"></script>

<!-- Sparkline -->
<script>
  window.currentPage = "{{ $currentPage }}";
  const URL_WEB_FRONT = "{{ env('URL_WEB_FRONT', 'https:/babilonia.io') }}";
</script>
@if($currentPage == "home")

<script src="@asset('public/plugins/sparklines/sparkline.js')?{{env('APP_JS_VERSION')}}"></script>

<!-- JQVMap -->
{{-- <script src="@asset('public/plugins/jqvmap/jquery.vmap.min.js')?{{env('APP_JS_VERSION')}}"></script> --}}
{{-- <script src="@asset('public/plugins/jqvmap/maps/jquery.vmap.usa.js')?{{env('APP_JS_VERSION')}}"></script> --}}
<script src="@asset('public/plugins/jqvmap/jquery-jvectormap-2.0.5.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/jqvmap/jquery-vectormap.peru.js')?{{env('APP_JS_VERSION')}}"></script>

@endif
<!-- Bootstrap select -->
<script src="@asset('public/plugins/bootstrap-select/js/bootstrap-select.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- jQuery Knob Chart -->
<script src="@asset('public/plugins/jquery-knob/jquery.knob.min.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- daterangepicker -->
<script src="@asset('public/plugins/moment/moment.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/daterangepicker/daterangepicker.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="@asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- Summernote -->
<script src="@asset('public/plugins/summernote/summernote-bs4.min.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- overlayScrollbars -->
<script src="@asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- AdminLTE App -->
<script src="@asset('public/assets/js/adminlte.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="@asset('public/assets/js/demo.js')?{{env('APP_JS_VERSION')}}"></script>
@if($currentPage == "home")
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="@asset("public/assets/js/pages/dashboard.js")"></script>-->
@endif
<script src="@asset('public/plugins/sweetalert2/sweetalert2.min.js')?{{env('APP_JS_VERSION')}}"></script>

<script src="@asset('public/assets/js/handlebars.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/assets/js/inputmask.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/assets/js/axios.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/assets/js/app.js')?{{env('APP_JS_VERSION')}}"></script>
<script>
  window.APP_BASE_EP = "{{ APP_BASE_EP }}";
  window.APP_LANG = "{{ APP_LANG }}";
  window.APP_LANG_LISTING_TYPE = {!! json_encode(APP_LANG_LISTING_TYPE) !!};
  window.APP_LANG_PROPERTY_TYPE = {!! json_encode(APP_LANG_PROPERTY_TYPE) !!};
  window.APP_LANG_ALERT_TYPE = {!! json_encode(APP_LANG_ALERT_TYPE) !!};
  window.APP_LANG_ALERT_STATE = {!! json_encode(APP_LANG_ALERT_STATE) !!};
  window.APP_LANG_STATE = {!! json_encode(APP_LANG_STATE) !!};
  window.APP_LANG_LEADS_KEYS = {!! json_encode(APP_LANG_LEADS_KEYS) !!};
  window.APP_LANG_ADS_TYPE = {!! json_encode(APP_LANG_ADS_TYPE) !!};
  window.APP_LANG_SOURCE = {!! json_encode(APP_LANG_SOURCE) !!};
  window.APP_LANG_PACKAGE_CATEGORY = {!! json_encode(APP_LANG_PACKAGE_CATEGORY) !!};
  window.APP_LANG_CLIENTS_STATE = {!! json_encode(APP_LANG_CLIENTS_STATE) !!};
  window.APP_LANG_CLAIMS_STATE = {!! json_encode(APP_LANG_CLAIMS_STATE) !!};
  window.filtersParamsTypes = {!! json_encode(FILTERSPARAMSTYPES) !!};
  window.permissions = {!! json_encode($permissions??[]) !!};
</script>
@yield("scripts")
@stack('child-scripts')

</body>
</html>
