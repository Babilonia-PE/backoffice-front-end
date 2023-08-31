<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Backoffice | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ secure_asset("plugins/fontawesome-free/css/all.min.css") }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ secure_asset("plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ secure_asset("assets/css/adminlte.min.css") }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>BACK</b>OFFICE</a>
  </div>
  @if(isset($message))
    <div class="alert alert-@if(isset($type)){{$type}}@else{{"warning"}}@endif " role="alert">
      {{ $message }}
    </div>
  @endif
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="/login" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="User" required>
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
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ secure_asset("plugins/jquery/jquery.min.js") }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ secure_asset("plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ secure_asset("assets/js/adminlte.min.js") }}"></script>
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
