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
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {{ $page_title or "Page Title" }}
                        <small>{{ $page_description or null }}</small>
                    </h1>
                    <!-- You can dynamically generate breadcrumbs here -->
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                        <li class="active">Here</li>
                    </ol>
                </section>

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
 <!-- Chat -->
        
         <div class="col-md-3" id="chat-area">
          <!-- DIRECT CHAT SUCCESS -->
          <div class="box box-success direct-chat direct-chat-success">
            <div class="box-header with-border">
              <h3 class="box-title">Chat</h3>

              <div class="box-tools pull-right">
              
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
         
          
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">Alexander Pierce</span>
                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                  </div>
                  <!-- /.direct-chat-info -->
                  <img class="direct-chat-img" src="{{asset('bower_components/AdminLTE/dist/img/user1-128x128.jpg')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    Is this template really for free? That's unbelievable!
                  </div>
                  <!-- /.direct-chat-text -->
                </div>
                <!-- /.direct-chat-msg -->

                <!-- Message to the right -->
                <div class="direct-chat-msg right">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">Sarah Bullock</span>
                    <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                  </div>
                  <!-- /.direct-chat-info -->
                  <img class="direct-chat-img" src="{{asset('bower_components/AdminLTE/dist/img/user3-128x128.jpg')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    You better believe it!
                  </div>
                  <!-- /.direct-chat-text -->
                </div>
                <!-- /.direct-chat-msg -->
              </div>
              <!--/.direct-chat-messages-->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="input-group">
                  <input name="message" placeholder="Type Message ..." class="form-control" type="text">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-success btn-flat">Send</button>
                      </span>
                </div>
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
         </div>
        <!-- Chat -->


        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.1.4 -->
        <script src="{{asset('bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

        <!-- Bootstrap 3.3.5 -->
        <script src="{{asset('bower_components/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>

        <!-- Underscore JS -->
        <script src="{{asset('js/underscorejs.min.js')}}"></script>


        <!-- SOCKET IO -->
        <script src="{{asset('js/socket.io.js')}}"></script>
        <script>
            var socket = new io.connect("{{getenv('SOCKET_URL')}}",{reconnect: true});
        </script>
        <script src="{{asset('js/receiver.js')}}"></script>
        @if(Session::get('user_id'))
        <script>
            socket.on('connect', function () {
                socket.emit('sendId', {id: "{{ Session::get('user_id') }}" , name: "{{ Session::get('user_data')['name']}}",avatar: "{{ Session::get('user_data')['avatar']}}"});
            });
        </script>
        @endif
        <!-- AdminLTE App -->
        <script src="{{asset('bower_components/AdminLTE/dist/js/app.min.js')}}"></script>
        <script src="{{asset('js/chat.js')}}"></script>

        @yield('footer_scripts')
        <!-- Overlay -->
        <div class='overlay-update overlay-message'>
            <h1><i class='fa fa-spinner fa-spin'></i> Admin Has Changed Your Account Settings , please wait a moment</h1>
        </div>
        
        <div class='overlay-ban overlay-message'>
            <h1><i class='fa fa-spinner fa-spin'></i> Admin Has Banned You , please wait a moment</h1>
        </div>
        <!-- Overlay -->
        
        
       
    </body>
</html>