<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if(session('user-proxy-id'))
        <meta name="user-proxy-id" content="{{session('user-proxy-id')}}">
        @endif
        <title>Hire a Van with Driver | Transportation service Europe</title>
        <meta name="description" content="Looking to hire a van with a driver for your next move? Easy Move Europe offers reliable and professional van hire services. Visit our website for more info."/>
        <meta name="keywords" content="Hire a van with driver, Moving company, Transportation service Europe, Delivery van service, Europe Removals Company"/>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            jQuery(document).ready(function($){
                $("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("toggled");
                });
            })
        </script>
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
        <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
        @yield('style')
        <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-7EZML0W28R"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-7EZML0W28R');
</script>


<meta name="google-site-verification" content="f-j9SdKa7QM-S1KMFzJ68oSGDRDgldzib-m8d5JvEsg" />
    </head>
    <body>
        <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
            <!-- @include("partials.adminSidebar") -->
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light border-bottom">
                    <!-- <button class="btn btn-secondary" id="menu-toggle"><i class="fa fa-bars"></i></button> -->
                    <a class="navbar-brand" href="{{ url('/') }}"><img class="logo-img" src="{{ asset('img/logo(bg).png') }}" alt="logo image"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="list-group list-group-flush d-flex mr-5" style="border-bottom:none!important; flex-flow: row;">
                            <a href="{{url('admin/adminDashboard')}}" class="list-group-item list-group-item-action">Dashboard</a>
                            <a href="{{url('admin/adminUser')}}" class="list-group-item list-group-item-action">Users</a>
                            <a href="{{url('admin/adminCompany')}}" class="list-group-item list-group-item-action">Companies</a>
                            <a href="{{url('admin/categories')}}" class="list-group-item list-group-item-action">Categories</a>
                            <a href="{{url('admin/blogs')}}" class="list-group-item list-group-item-action">Blogs</a>

                            <a href="{{url('admin/adminRequest')}}" class="list-group-item list-group-item-action">Requests</a>

                            <!-- <a href="adminService" class="list-group-item list-group-item-action">Service</a> -->
                            <!-- <a href="adminCost" class="list-group-item last-list-item list-group-item-action">Cost</a> -->
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link logout-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Account
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li> -->
                    </ul>
                    </div>
                </nav>
                @if(!isset($dont_show_container))
                <div class="row" style="margin:15px 5%;">

                    @endif
                    @yield('content')
                    @if(!isset($dont_show_container))
                </div>
                @endif
            </div>
        <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->
    </body>
</html>
