@extends('layouts/blank')
@section('content')
<!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
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
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <a href="{{url('register')}}" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
@stop