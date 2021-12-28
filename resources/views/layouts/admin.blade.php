<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Admin - @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <!-- Page Style -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- Flag -->
    <link rel="stylesheet" href="{{ asset('plugins/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="icon" href="{{ asset('logo.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('/plugins/daterangepicker/daterangepicker.css') }}">

    @yield('style')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" class="nav-link">Home</a>
            </li>
           
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown ml-auto">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false"> <i class="{{'flag-icon flag-icon-'.app()->getLocale()}}"></i> </a>
                <div class="dropdown-menu dropdown-menu-right p-0" style="left: inherit; right: 0px;">
                    <!-- <a href="{{ route('lang.change', ['locale' => app()->getLocale()=='pl'?'en':'pl']) }}" class="dropdown-item"> <i class="{{'mr-2 flag-icon flag-icon-'.(app()->getLocale()=='pl'?'en':'pl')}}"></i> {{app()->getLocale()=='pl'?'English':'Polish'}} </a> -->
                    <a href="{{ route('lang.change', ['locale' => 'en']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-en"></i> English </a>
                    <a href="{{ route('lang.change', ['locale' => 'pl']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-pl"></i> Polish </a>
                    <a href="{{ route('lang.change', ['locale' => 'se']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-se"></i> Svenska </a>
                    <a href="{{ route('lang.change', ['locale' => 'de']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-de"></i> Deutsch </a>
                    <a href="{{ route('lang.change', ['locale' => 'dk']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-dk"></i> Dansk </a>
                    <a href="{{ route('lang.change', ['locale' => 'cz']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-cz"></i> Czech </a>
                    <a href="{{ route('lang.change', ['locale' => 'es']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-es"></i> Espanol </a>
                        
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cog"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt mr-2"></i>{{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="brand-link">
            <img src="{{ asset('assets/img/logo-white.png') }}"
                 alt="AdminLTE Logo"
                 class="admin-brand-logo"
                 style="width:75%;">
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link @if($menu==='dashboard') active @endif">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    @if(in_array("Members",auth()->user()->menuRole()))
                    <li class="nav-item has-treeview @if($menu === 'members') menu-open @endif">
                        <a href="#" class="nav-link @if($menu==='members') active @endif">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Members
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.list') }}" class="nav-link @if($submenu === 'users') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('copywriters.list') }}" class="nav-link @if($submenu === 'copywriters') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Copywriters</p>
                                </a>
                            </li>
							 <li class="nav-item">
                                <a href="{{ route('copywriters.waiter_list') }}" class="nav-link @if($submenu === 'waiter') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Cop... Waiting to Accept</p>
                                </a>
                            </li>
							 <li class="nav-item">
                                <a href="{{ route('member.waiter_list') }}" class="nav-link @if($submenu === 'waiter') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Waiting to Accept</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(in_array("Projects",auth()->user()->menuRole()))
					<li class="nav-item has-treeview @if($menu === 'projects') menu-open @endif">
                        <a href="#" class="nav-link @if($menu==='projects') active @endif">
                            <i class="nav-icon fas fa-pen-square"></i>
                            <p>
                                Projects
                                <i class="right fas fa-angle-left"></i>
								<ion-icon name="card-outline"></ion-icon>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.project.active') }}" class="nav-link @if($submenu === 'active') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Current Active</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.project.sketch') }}" class="nav-link @if($submenu === 'sketch') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sketch</p>
                                </a>
                            </li>
							 <li class="nav-item">
                                <a href="{{ route('admin.project.history') }}" class="nav-link @if($submenu === 'history') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>History</p>
                                </a>
                            </li>
							
                        </ul>
                    </li>
                    @endif

                    @if(in_array("CategoryEditor",auth()->user()->menuRole()))
                    <li class="nav-item">
                        <a href="{{ route('category.edit')}}" class="nav-link @if($menu==='category') active @endif">
							<i class="nav-icon fas fa-clone"></i>
                            <p>
                                Category Editor
                            </p>
                        </a>
                    </li>
                    @endif

                    @if(in_array("TaxOffices",auth()->user()->menuRole()))
                    <li class="nav-item">
                        <a href="{{ route('tax-office')}}" class="nav-link @if($menu==='tax') active @endif">
                            <i class="nav-icon fas fa-piggy-bank"></i>
                            <p>
                                Tax Offices
                            </p>
                        </a>
                    </li>
                    @endif

                   

                

                    @if(in_array("Marketplace",auth()->user()->menuRole()))
					<li class="nav-item has-treeview @if($menu === 'markets') menu-open @endif">
                        <a href="#" class="nav-link @if($menu==='markets') active @endif">
							<i class="nav-icon fas fa-poll"></i>
                            <p>
                                Marketplace
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('markets.pending') }}" class="nav-link @if($submenu==='pending') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sells to Accept</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('markets.active') }}" class="nav-link @if($submenu==='active') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Marketplace Active</p>
                                </a>
                            </li>
							 <li class="nav-item">
                                <a href="{{ route('markets.history') }}" class="nav-link @if($submenu==='history') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Marketplace History</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(in_array("Disputes",auth()->user()->menuRole()))
					<li class="nav-item ">
                        <a href="#" class="nav-link">
						<i class="nav-icon fas fa-envelope-open-text"></i>
                            <p>
                                Disputes
                            </p>
                        </a>
                    </li>
                    @endif

                    @if(in_array("AllMessages",auth()->user()->menuRole()))
					<li class="nav-item @if($menu === 'messages') active @endif">
                        <a href="{{ route('admin.messages') }}" class="nav-link @if($menu === 'messages') active @endif">
						<i class="nav-icon fas fa-envelope-open-text"></i>
                            <p>
                                All Messages
                            </p>
                        </a>
                    </li>
                    @endif

                    @if(in_array("Documents",auth()->user()->menuRole()))
                    <li class="nav-item has-treeview @if($menu === 'documents') menu-open @endif">
                        <a href="#" class="nav-link  @if($menu === 'documents') active @endif">
						<i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                Documents
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.invoices') }}" class="nav-link @if($submenu==='invoice') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Client Invoices</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.bills') }}" class="nav-link @if($submenu==='bill') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Copywriters Bills</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(in_array("Financial",auth()->user()->menuRole()))
                    <li class="nav-item has-treeview @if($menu === 'payments') menu-open @endif">
                        <a href="#" class="nav-link @if($menu==='payments') active @endif">
			                <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                Financial
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.withdrawal.pending') }}" class="nav-link @if($submenu==='pending') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Payouts to Accept</p>
                                </a>
                            </li>
							<li class="nav-item">
                                <a href="{{ route('admin.withdrawal.history') }}" class="nav-link @if($submenu==='withdraw-history') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Payouts History</p>
                                </a>
                            </li>
							<li class="nav-item">
                                <a href="{{ route('admin.transaction.history') }}" class="nav-link @if($submenu==='transaction-history') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Transaction History</p>
                                </a>
                            </li>
							@if(in_array("BonusCode",auth()->user()->menuRole()))
							<li class="nav-item">
                                <a href="{{ route('bonus-code')}}" class="nav-link @if($menu==='bonus_code') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Bonus Codes</p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if(in_array("Statistics",auth()->user()->menuRole()))
			        <li class="nav-item">
                        <a href="#" class="nav-link">
						<i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Statistics
                            </p>
                        </a>
                    </li>
                    @endif

                    @if(in_array("UserManager",auth()->user()->menuRole()))
			        <li class="nav-item">
                        <a href="{{ route('admin.root') }}" class="nav-link">
						<i class="nav-icon fas fa-user-shield"></i>
                            <p>
                                User Manager
                            </p>
                        </a>
                    </li>
                    @endif

                    @if(in_array("UserLevel",auth()->user()->menuRole()))
			        <li class="nav-item">
                        <a href="{{ route('admin.level') }}" class="nav-link">
						<i class="nav-icon fas fa-user-shield"></i>
                            <p>
                                User Level
                            </p>
                        </a>
                    </li>
                    @endif

                    @if(in_array("ServiceLogs",auth()->user()->menuRole()))
					<li class="nav-item">
                        <a href="#" class="nav-link">
						<i class="nav-icon fas fa-user-shield"></i>
                            <p>
                                Service Logs
                            </p>
                        </a>
                    </li>
                    @endif

                    @if(in_array("SettingGlobal",auth()->user()->menuRole()))
					<li class="nav-item has-treeview @if($menu === 'payments') menu-open @endif">
                        <a href="#" class="nav-link @if($menu==='payments') active @endif">
			                <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Setting Global
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.settings') }}" class="nav-link @if($menu==='settings') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Fees and Other</p>
                                </a>
                            </li>
							<li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tax Settings</p>
                                </a>
                            </li>
							@if(in_array("Countries",auth()->user()->menuRole()))
							<li class="nav-item">
                                <a href="{{ route('countries')}}" class="nav-link @if($menu==='countries') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Countries Register</p>
                                </a>
                            </li>
							@endif
							<li class="nav-item">
                                <a href="#" class="nav-link @if($submenu==='history') active @endif">
                                    <i class="far fa-euro-sign nav-icon"></i>
                                    <p>Currency A/D</p>
                                </a>
                            </li>
							<li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stripe Setting</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.payu.edit') }}" class="nav-link @if($submenu==='payu-settings') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>PayU Settings</p>
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
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('subtitle')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">@yield('subtitle')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        @yield('content')
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">{{ config('app.name') }}</a>.</strong> All rights
        reserved.
    </footer>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script src="{{asset('assets/vendor/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

<script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Page script -->
@yield('script')
</body>
</html>
