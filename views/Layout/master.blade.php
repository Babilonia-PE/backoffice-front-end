  @include('includes.header')

  <!-- Main Sidebar Container -->
  @include('includes.aside')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    @hasSection('page')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0">@yield('page')</h1>
          </div><!-- /.col -->          
          <div class="col-auto">
            @yield('button')
          </div><!-- /.col -->       
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @else 
        <div class="mb-3"></div>
    @endif
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        @yield('content')
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  @include('includes.footer')
