<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Backoffice | Login</title>
  @base
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="@asset('public/plugins/fontawesome-free/css/all.min.css')?{{env('APP_CSS_VERSION')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="@asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')?{{env('APP_CSS_VERSION')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="@asset('public/assets/css/adminlte.min.css')?{{env('APP_CSS_VERSION')}}">
  <link rel="stylesheet" href="@asset('public/assets/css/login.css')?{{env('APP_CSS_VERSION')}}">
</head>
<body class="hold-transition login-page bg-white">
<div class="login-box">
  <div class="login-logo">
    <a href="/login">
      <img src="@asset('public/assets/img/logo.svg')" alt="">
    </a>
  </div>
  @if(isset($message))
    <div class="alert alert-@if(isset($type)){{$type}}@else{{"warning"}}@endif " role="alert">
      {{ $message }}
    </div>
  @endif
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      {{-- <p class="login-box-msg">Sign in to start your session</p> --}}

      <form action="/update-account-2fa" method="post" class="form-qr text-center">
        <p class="text-center text-dark"><strong>Verifica tu cuenta</strong></p>
        <p class="text-center text-dark">Escanea el codigo QR por primera y unica vez<br/>
          <small>(puede usar Google Authenticator)</small>
        </p>
        <img src="{{ $image }}" alt="">
        <p class="text-center text-dark">Ingresa el codigo de verificaci&oacute;n generador por tu aplicación</p>
         
        <input id="code" name="code" type="text" class="form-control text-center" placeholder="___ ___" autocomplete="off" autofocus>
         
        <button class="btn btn-primary flex-fill w-100 mt-3 mb-3" type="submit">Siguiente</button>

        <a href="/logout" class="text-center text-black m-auto mt-2">Regresar</a>
      </form>

      <!-- /.social-auth-links -->

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="@asset('public/plugins/jquery/jquery.min.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- Bootstrap 4 -->
<script src="@asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/sweetalert2/sweetalert2.min.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- AdminLTE App -->
<script src="@asset('public/assets/js/adminlte.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/assets/js/inputmask.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/assets/js/app.js')?{{env('APP_JS_VERSION')}}"></script>
<script>
setMask('#code', { mask: "999 999", showMaskOnHover: false, placeholder: "___ ___", rightAlign:false });
</script>
</body>
</html>
