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
</head>
<body class="hold-transition login-page bg-white">
<div class="login-box">
  <div class="login-logo">
    <a href="/login">
      <img src="@asset("public/assets/img/logo.svg")" alt="">
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

      <form action="/login" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="nombre.apellido" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" id="password" required>
          <div class="input-group-append">
            <button class="input-group-text" type="button" id="hidenshowpassword">
              <span class="fa fa-eye"></span>
            </button>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
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
<!-- AdminLTE App -->
<script src="@asset('public/assets/js/adminlte.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script>
  $("#hidenshowpassword").click(function(e){
    let input = document.getElementById("password");
    if(input.type == 'password'){
      input.type = "text";
      $(this).children("span").removeClass("fa-eye");
      $(this).children("span").addClass("fa-eye-slash");
    }else{
      input.type = "password";
      $(this).children("span").addClass("fa-eye");
      $(this).children("span").removeClass("fa-eye-slash");
    }
  });
</script>
</body>
</html>
