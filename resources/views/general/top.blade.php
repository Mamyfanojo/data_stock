<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> @yield('title') </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('../../plugins/fontawesome-free/css/all.min.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CDN Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('../../dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('articles.index') }}" class="nav-link {{ request()->is('articles') ? 'activo' : '' }}">Liste des données</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('zone.show1') }}" class="nav-link {{ request()->is('zone*') ? 'activo' : '' }}">Zones</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('list.mada') }}" class="nav-link {{ request()->is('listeMada') ? 'activo' : '' }}">Liste des données MADA</a>
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

      <!-- Messages Dropdown Menu -->

      <!-- Notifications Dropdown Menu -->
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'activee' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            DASHBOARD
                        </p>
                    </a>
                </li>

            <li class="nav-item">
                <a href="{{ url('/avurnav') }}" class="nav-link {{ request()->is('avurnav*') ? 'activee' : '' }}">
                <!-- <i class="nav-icon fas fa-th"></i> -->
                <i class="nav-icon fas fa-ship"></i>
                <p>
                    FORMAT AVURNAV
                    <!-- <span class="right badge badge-danger">New</span> -->
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/pollutions') }}" class="nav-link {{ request()->is('pollution*') ? 'activee' : '' }}">
                <!-- <i class="nav-icon fas fa-th"></i> -->
                <i class="nav-icon fas fa-smog"></i>
                <p>
                    POLLUTIONS
                    <!-- <span class="right badge badge-danger">New</span> -->
                </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/sitreps') }}" class="nav-link {{ request()->is('sitrep*') ? 'activee' : '' }}">
                <!-- <i class="nav-icon fas fa-th"></i> -->
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                    FORMAT SITREP
                    <!-- <span class="right badge badge-danger">New</span> -->
                </p>
                </a>
            </li>
            <li class="nav-item">
            <a href="{{ route('bilan_sars.index') }}" class="nav-link {{ request()->is('bilan*') ? 'activee' : '' }}" class="nav-link">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>
                BILAN SAR
                <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('bilan_sars.index') }}" class="nav-link {{ request()->is('bilan_sars') ? 'activee' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Liste BILAN SAR</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('type_evenements.index') }}" class="nav-link {{ request()->is('bilan_sars/type_evenements*') ? 'activee' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Types d'evenement</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cause_evenements.index') }}" class="nav-link {{ request()->is('bilan_sars/cause_evenements*') ? 'activee' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Causes d'evenement</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('regions.index') }}" class="nav-link {{ request()->is('bilan_sars/region*') ? 'activee' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Region</p>
                  </a>
                </li>
            </ul>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 px-4">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- ETO NY MANARAKA -->
        @yield('content')
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- script pour chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- jQuery -->
<script src="{{ asset('../../plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('../../plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('../../plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('../../dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('../../dist/js/demo.js') }}"></script>


</body>
<style>
  .activee {
    background-color:rgb(73, 80, 87);
    color: white;
  }
  .activo {
    border-bottom: 1px solid black;
  }
</style>
</html>