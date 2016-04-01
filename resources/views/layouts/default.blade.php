<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> {{ $page_title or '' }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="{{asset('bower_components/AdminLTE/bootstrap/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('bower_components/AdminLTE/dist/css/AdminLTE.min.css')}}">
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link rel="stylesheet" href="{{asset('bower_components/AdminLTE/dist/css/skins/skin-blue.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/animate.css')}}">
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">

        @yield('header_styles')

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <!--
    BODY TAG OPTIONS:
    =================
    Apply one or more of the following classes to get the
    desired effect
    |---------------------------------------------------------|
    | SKINS         | skin-blue                               |
    |               | skin-black                              |
    |               | skin-purple                             |
    |               | skin-yellow                             |
    |               | skin-red                                |
    |               | skin-green                              |
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |
    |               | sidebar-mini                            |
    |---------------------------------------------------------|
    -->
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <!-- Main Header -->
            @include('partials/header')
            <!-- Left side column. contains the logo and sidebar -->
            @include('partials/sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                @include('partials/breadcrumb')

                <!-- Main content -->
                <section class="content">

                    <!-- Your Page Content Here -->
                    @yield('content')
                    <div class="test"></div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            @include('partials/footer')
            <!-- Control Sidebar -->
            @include('partials/sidebar-control')
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        @include('includes/chat-box')

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.1.4 -->
        <script src="{{asset('bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

        <!-- Bootstrap 3.3.5 -->
        <script src="{{asset('bower_components/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>

        <!-- Underscore JS -->
        <script src="{{asset('js/underscorejs.min.js')}}"></script>

        <!-- JQuery Visible plugin -->
        <script src="{{asset('js/jquery.visible.min.js')}}"></script>
        
        <!-- JQuery Typing plugin -->
        <script src="{{asset('js/jquery.typing.min.js')}}"></script>

        <!-- Noty -->
        <script src="{{asset('js/noty.js')}}"></script>

        <!-- Artisan JS -->
        <script src="{{asset('js/Artisan.js')}}"></script>

        <!-- Artisan JS -->
        <script src="{{asset('js/ArtisanChat.js')}}"></script>

        @include('includes/socket')

        <script src="{{asset('js/chat.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('bower_components/AdminLTE/dist/js/app.min.js')}}"></script>

        @yield('footer_scripts')

        @include('includes/overlays')


    </body>
</html>