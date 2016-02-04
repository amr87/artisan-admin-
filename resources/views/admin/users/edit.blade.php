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
        <form action="{{url('/admin/users')}}/{{$user->id}}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT" />
            <div class="col-md-6">

                <div class="form-group">
                    <label><strong> First Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ $name[0] }}"  type="text" placeholder="First Name" name="first_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label><strong> Last Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ $name[1] }}" type="text" placeholder="Last Name" name="last_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label><strong> Username</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input value="{{ $user->username }}" disabled="" type="text" placeholder="Username" name="username" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label><strong> Email</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input value="{{ $user->email }}" required="" type="email" placeholder="Email" name="email" class="form-control">
                    </div>
                </div>




                <div class="form-group">
                    <label><strong> Bio</strong></label>

                    <textarea name="bio" class="textarea" placeholder="Place some text here" style="width: 100%; height: 190px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $user->bio }}</textarea>

                </div>

            </div>
            <div class="col-md-6">



                <div class="image-upload">
                    <label for="avatar">
                        <strong> Change Avatar</strong>
                        <img class="img-circle" src="{{$avatar}}"/>
                        <div class="rolling"></div>
                    </label>

                    <input  type="file" id="avatar" name="avatar"/>
                </div>
               @if($user->social == "0")
                <div class="form-group">
                    <label><strong>Old Password</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input   type="password" placeholder="Old Password" name="old_password" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label><strong> New Password</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input   type="password" placeholder="New Password" name="password" class="form-control">
                    </div>
                </div>
               @endif
                <div class="form-group">
                    <label><strong> Phone</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input value="{{ $user->phone }}" type="text" placeholder="phone" name="phone" class="form-control">
                    </div>
                </div>


                @if($user->id !=1)
                @if(count($roles) > 0)
                <div class="form-group">
                    <label><strong> Role(s)</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                        <select class="col-md-6" multiple="" id="roles" name="role[]">
                            @foreach($roles as $role)
                            <option <?php if (in_array($role->id, $rolesArray)): ?> selected <?php endif; ?> value="{{$role->id}}">{{$role->label}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @endif
                @endcheck
                <br>
                <button type="submit" class="btn btn-success  btn-block" name="submit"><i class="fa fa-user-md"></i> Update User</button>
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
<script src="{{asset('js/upload.js')}}"></script>
<script>
$(function () {
    $("input[name='password'],input[name='old_password']").val('');

    $("select#roles").select2();
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
    var reader;
    $("input#avatar").on('change', function (e) {

        var input = $(this);

        var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (e.target.files) {

            var extension = e.target.files[0].name.split('.').pop().toLowerCase();

            var isSuccess = fileTypes.indexOf(extension) > -1;

            if (!isSuccess) {
                alert("You must upload an image");
                return;
            }

            var size = ~~(e.target.files[0].size / 1024);

            if (size > 1024) {
                alert("You can`t upload image larger than 1 MB");
                return;
            }

            reader = new FileReader();

            reader.readAsDataURL(e.target.files[0]);

            $(input).upload("{{url('/admin/users/upload')}}/{{Request::segment(3)}}", function (success) {

                $(input).prev().find("img").attr("src", reader.result);

                var user_id = {{ Request::segment(3)}}
                var ID = {{Session::get('user_id')}}
      
                if (user_id == ID) {
                    $('img.img-circle,img.user-image').attr("src", reader.result);
                    }
                    $('.image-upload .rolling').hide();
                }
                , function (prog, value) {

            });

        } else {

            alert("No File Chosen !");
        }

    });
});
</script>
@endsection
@endsection