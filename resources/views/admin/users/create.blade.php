@extends('layouts/default')

@section('content')
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/AdminLTE/plugins/select2/select2.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}"/>
@endsection

<div class="box">
    <div class="box-header">


    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @include('admin/messages')
        <form action="{{url('/admin/users')}}" method="POST" enctype="multipart/form-data">
            <div class="col-md-6">

                <div class="form-group">
                    <label><strong> First Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ old('first_name') }}"  type="text" placeholder="First Name" name="first_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label><strong> Last Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ old('last_name') }}" type="text" placeholder="Last Name" name="last_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label><strong> Username</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input value="{{ old('username') }}" required="" type="text" placeholder="Username" name="username" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label><strong> Email</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input value="{{ old('email') }}" required="" type="email" placeholder="Email" name="email" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label><strong> Password</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input value="{{ old('password') }}" required="" type="password" placeholder="Password" name="password" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label><strong> Confirm Password</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input value="{{ old('password_confirmation') }}" required="" type="password" placeholder="Confirm Password" name="password_confirmation" class="form-control">
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                
                <div class="form-group">
                    <label><strong> Phone</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input value="{{ old('phone') }}" type="text" placeholder="phone" name="phone" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label><strong> Bio</strong></label>

                    <textarea name="bio" class="textarea" placeholder="Place some text here" style="width: 100%; height: 170px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('bio') }}</textarea>

                </div>

                @if(count($roles) > 0) 
                <div class="form-group">
                    <label><strong> Role(s)</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                        <select class="col-md-6" multiple="" id="roles" name="role[]">
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->label}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @endif
                <br>
                <button type="submit" class="btn btn-success  btn-block" name="submit"><i class="fa fa-user-plus"></i> Create User</button>
            </div>
            {{ csrf_field() }}



        </form>        
    </div>

</div>
<!-- /.box -->
<!-- DataTables -->
@section('footer_scripts')
<script src="{{asset('bower_components/AdminLTE/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script>
$(function () {

    $("select#roles").select2();
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
});
</script>
@endsection
@endsection