<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta  name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="cache-control" content="private, max-age=0, no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'Blog') }}</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

   
    <!-- Bootstrap Core css -->
    {{-- <link href="{{asset('contents/admin')}}/css/sweetalert2.min.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.19.1/sweetalert2.min.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.19.1/sweetalert2.min.css" rel="stylesheet">
    <link href="{{asset('contents/admin')}}/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    @stack('css')
    <link href="{{asset('contents/admin')}}/plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="{{asset('contents/admin')}}/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="{{asset('contents/admin')}}/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{{asset('contents/admin')}}/plugins/morrisjs/morris.css" rel="stylesheet" />
    <link href="{{asset('contents/admin')}}/css/style.css" rel="stylesheet">
    <link href="{{asset('contents/admin')}}/css/themes/all-themes.css" rel="stylesheet" />
    <link href="{{asset('contents/admin')}}/css/custom.css" rel="stylesheet">
</head>
<body class="theme-blue">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    @include('admin.navbar')
    <!-- #Top Bar -->
    <!-- Sidebar -->
    @include('admin.sidebar')
    <!-- END Sidebar -->

    <!-- Content -->
    @yield('content')
    <!-- Content Ends -->

    <!-- Jquery Core js -->
    <script src="{{asset('contents/admin')}}/plugins/jquery/jquery.min.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/node-waves/waves.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/jquery-countto/jquery.countTo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.19.1/sweetalert2.min.js"></script>
    
    @stack('js')
    <!-- Custom js -->
    <script src="{{asset('contents/admin')}}/js/admin.js"></script>
    <script src="{{asset('contents/admin')}}/js/pages/index.js"></script>
    <script src="{{asset('contents/admin')}}/js/demo.js"></script>
    <script src="{{asset('contents/admin')}}/js/custom.js"></script>
    
</body>
</html>
