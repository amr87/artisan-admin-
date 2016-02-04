@extends('layouts/blank')
@section('title')
Administartion | Login
@endsection
@section('content')
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Forget Password</h4>
            </div>
            <div class="modal-body">
                <p class="wait-rest text hidden"> Please Wait ... 
                <img class="img-circle" src="{{ url('images/rolling.gif')}}" width="30" height="30"/>
                </p>
                <p class="success-rest text hidden"> <i class="fa fa-lg fa-check-circle text-green"></i> Please check your inbox for rest link </p>
                <p class="error-rest text hidden"> <i class="fa fa-lg fa-warning text-red"></i> This email is not recognized , please provide a valid email </p>
                
                <div class="form-group">
                    <label><strong> Email</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input  required="" type="email" placeholder="Email" id="email" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary resetPassword">Request  Password Reset</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /.login-logo -->
<div class="login-box-body">
    <h1 class="login-box-msg">Artisan</h1>
    @include('admin/messages')
    <form action="{{url('/login')}}" method="post">
        <div class="form-group has-feedback">
            <input required="" type="text" class="form-control" name="username" placeholder="Username">
            <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input required="" type="password" class="form-control" name="password" placeholder="Password">
            <span class="fa fa-lock form-control-feedback"></span>
        </div>
        {{ csrf_field() }}
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox"> Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="{{url('/facebook')}}" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
            Facebook</a>
<!--        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
            Google+</a>-->
    </div>
    <!-- /.social-auth-links -->

    <a href="#" data-toggle="modal" data-target="#resetPasswordModal">I forgot my password</a><br>
<!--    <a href="{{url('register')}}" class="text-center">Register a new membership</a>-->

</div>
<!-- /.login-box-body -->
@stop