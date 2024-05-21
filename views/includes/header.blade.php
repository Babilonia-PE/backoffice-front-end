<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @base
  <title>@hasSection('page') @yield('page') | BackOffice @else BackOffice @endif</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="@asset('public/plugins/fontawesome-free/css/all.min.css')?{{env('APP_CSS_VERSION')}}">
  <!-- Babilonia Icons -->
  <link rel="stylesheet" href="@asset('public/assets/css/icons.css')?{{env('APP_CSS_VERSION')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="@asset('public/assets/css/adminlte.min.css')?{{env('APP_CSS_VERSION')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="@asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')?{{env('APP_CSS_VERSION')}}">
  <link rel="stylesheet" href="@asset('public/plugins/bootstrap-select/css/bootstrap-select.min.css')?{{env('APP_CSS_VERSION')}}">
  <!-- sweetalert2 -->
  <link rel="stylesheet" href="@asset('public/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?{{env('APP_CSS_VERSION')}}">
  <!-- Bootstrap country select -->
  <link rel="stylesheet" href="@asset('public/assets/css/bootstrap-select-country.min.css')?{{env('APP_CSS_VERSION')}}">
  <!-- Main styles -->
  <link rel="stylesheet" href="@asset('public/assets/css/main.css')?{{env('APP_CSS_VERSION')}}">

  @yield("styles")

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <div class="Loader">
      <div class="Loader_Content">
          <div class="CubeLoader">
              <div class="CubeLoader_Cube"></div>
              <div class="CubeLoader_Cube CubeLoader_Loader2__2"></div>
              <div class="CubeLoader_Cube CubeLoader_Loader4__3"></div>
              <div class="CubeLoader_Cube CubeLoader_Loader3__1"></div>
          </div>
      </div>
    </div>

  </div>


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Inicio</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" role="button" id="logout">
            <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->