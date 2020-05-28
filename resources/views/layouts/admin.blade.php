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

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>AdminLTE 3 | Starter</title>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin-lte/adminlte.css') }}" rel="stylesheet">
  <link href="{{ asset('css/font-awsome/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin-lte/adminlte.min.css.map') }}" rel="stylesheet">
  <link href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700') }}" rel="stylesheet">

  <style>
        #profile_image{
            height: 35px;
            width: 35px;
            float: left;
            border-radius: 50%;
        }

        .author-image{
            width: 80px;
            height: 80px;
            border-radius: 50%;
            float: left;
            margin: 10px;
        }

        #nav_image{
            height: 32px;
            width: 32px;
            top: 10px;
            border-radius: 50%;
        }

        .navbar-toggler{
            position: relative;
            padding-left: 50px;
        }

        #category_form{      
            width: inherit;
            display: none;
        }

        #category_form input, textarea{
          width: 100%;
        }

        #post_form{
            width: inherit;
            display: none;
        }

        #post_form input, textarea, button.checkbox-list-button{
          width: 100%;
        }

        button.checkbox-list-button{
            text-align: left;
        }

        #checkbox-list input{
            width: 2%;
        }

        .components-panel__arrow{
            float: right;
        }

        .close{
            position: absolute;
            right: 10px;
            top: 10px;
            font-weight: bold;
            font-family: sans-serif;
            cursor: pointer;
        }

        .pagination{
            display: inline-block;
        }
        
        .pagination a{
            border: 1px solid #ddd;
            float: left;
            padding: 8px 16px;
        }  

        a.pages:hover, .nextValue:hover, .preValue:hover{
            background-color: #ddd;
            cursor: pointer;
        }

        #category_table{
            display: none;
        }

        #post_table{
            display: none;
        }

        #comment_table{
            display: none;
        }

        #view_comment{
            display: none;
        }

        .checked{
           background-color: #ddd;
        }

        .actions{
            width: 200px;
            text-align: center;
        }

        td.actions button{
            margin: 5px;
        }

        #submitBtn, #submitPost{
            float: right;
        }

        #post_form button{
            margin: 5px 0px;
        }

        span.close{
            display: none;
        }

        #hideComment{
            margin: 5px;
        }
    </style>
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
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">    
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <img src="/uploads/avatars/{{ Auth::user()->avatar }}" id="nav_image">
            {{ Auth::user()->name }}
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('profile.show', Auth::user()->id ) }}"
                onclick="event.preventDefault();
                              document.getElementById('profile-form').submit();">
                {{ __('Profile') }}
            </a>

            <form id="profile-form" action="{{ route('profile.show', Auth::user()->id ) }}" method="GET" style="display: none;">
            </form>

            <a class="dropdown-item" href="{{ route('profile.show', Auth::user()->id ) }}"
                onclick="event.preventDefault();
                              document.getElementById('edit-profile-form').submit();">
                {{ __('Edit Profile info') }}
            </a>

            <form id="edit-profile-form" action="{{ route('profile.show', Auth::user()->id ) }}" method="GET">
            </form>

            <button class="dropdown-item" class="btn btn-danger" role="button" data-toggle="modal" data-target="#delete-profile-{{ Auth::user()->id }}">
                {{ __('Delete Profile') }}
            </button>

            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  @include('modals.deleteProfileModal')
  @include('modals.deletePostOrCategoryModal')

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/uploads/avatars/{{ Auth::user()->avatar }}" class="img-circle elevation-2" alt="User Image" id="profile_image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <p>
                Categories
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="#" id="index_category" class="nav-link">
                  <p>All Categories</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link" id="new_category">
                  <p>New Category</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <p>
                Posts
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link" id="index_post">
                  <p>All Posts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" id="new_post">
                  <p>New Post</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <p>
                Comments
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link" id="index_comment">
                  <p>Unapproved Comments</p>
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark" id="dashboard_header">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

            @yield('content')

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

</div>
<!-- ./wrapper -->


</body>

<!-- Scripts -->

@include('jquery.manageAdminFunctions')
@include('jquery.adminDashboardPostJS')

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin-lte/adminlte.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin-lte/adminlte.min.js.map') }}"></script>