<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ secure_asset("assets/img/AdminLTELogo.png") }}" alt="Backoffice" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Backoffice</span>
    </a>    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ secure_asset("assets/img/user2-160x160.jpg") }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block text-truncate">{{ auth("name") | camelcase }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                
          @foreach(menu() as $menu)
          <li class="nav-item">
            <a href="{{ $menu["url"]??'#' }}" class="nav-link {{ $menu["active"] ? 'active' : '' }}">
              <i class="{{ $menu["icon"]??"nav-icon fas fa-chart-pie" }}"></i>
              <p>
                {{ $menu["name"]??'' }}
              </p>
            </a>
          </li>
          @endforeach
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>