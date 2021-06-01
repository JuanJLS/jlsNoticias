<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Noticias JJLS - Backend</title>
@yield('prestyle')
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ url('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('assets/backend/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@yield('poststyle')
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
        <a href="{{ route('backend.noticia.index') }}" class="nav-link">Noticias Back-end</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('frontend.noticia.index') }}" target="_blank" class="nav-link">Noticias Front-end</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home')}}" class="nav-link">Login/Register</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    @if(str_contains(url()->current(), '/backend/noticia'))
    <form action="{{ route('backend.noticia.index') }}" class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input name="search" value="{{ $search ?? '' }}" class="form-control form-control-navbar" type="search" placeholder="Buscar Noticia" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    @elseif(str_contains(url()->current(), '/backend/comentario'))
    <form action="{{ route('backend.comentario.index') }}" class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input name="search" value="{{ $search ?? '' }}" class="form-control form-control-navbar" type="search" placeholder="Buscar Comentario" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    @endif
        
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ url('/assets/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">JJLS Noticias App</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ url('/assets/backend/dist/img/favicon.ico') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">BACKEND</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>
                Noticias
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('backend.noticia.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ver Noticias</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('backend.noticia.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear Noticia</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-comment-alt"></i>
              <p>
                Comentarios
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('backend.comentario.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ver Comentarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('backend.comentario.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear Comentario</p>
                </a>
              </li>
            </ul>
          </li>
          
           <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('backend.user.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Users</p>
                </a>
              </li>
          @if (Auth::id() == 1)
              <li class="nav-item">
                <a href="{{ route('backend.user.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create User</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            @yield('content')
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyleft &copy; 2021 JJLS.</strong>
  </footer>
</div>
@yield('prescript')
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

<script src="{{ url('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('assets/backend/dist/js/adminlte.min.js') }}"></script>
@yield('postscript')
</body>
</html>
