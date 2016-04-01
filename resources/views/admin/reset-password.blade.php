@extends('layouts/blank')
@section('title')
Administartion | Reset Password
@endsection
@section('content')
@include('admin/messages')
<!-- /.login-logo -->
<div class="login-box-body">
    <h1 class="login-box-msg">Artisan</h1>
    
    <form action="{{url('/reset-password')}}?email={{Request::Input('email')}}&token={{Request::Input('token')}}" method="post">
        <div class="form-group has-feedback">
            <input required="" type="password" class="form-control" name="password" placeholder="New Password">
            <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input required="" type="password" class="form-control" name="password_confirmation" placeholder="Confirm New Password">
            <span class="fa fa-lock form-control-feedback"></span>
        </div>
        {{ csrf_field() }}
        <div class="row">

            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
</div>
<!-- /.login-box-body -->
@stop