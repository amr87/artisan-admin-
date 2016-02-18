@extends('layouts/default')

@section('content')

@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/AdminLTE/plugins/select2/select2.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}"/>
@endsection

<div class="row">
         @include('admin/messages')
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
                            <div class="image-upload">
                    <label for="avatar">
                       
                        <img class="img-circle margin-left-30" src="{{$avatar}}"/>
                        <div class="rolling left-30">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </label>

                    <input  type="file" id="avatar" name="avatar"/>
                </div>

              <h3 class="profile-username text-center">{{$user->display_name}}</h3>

              <p class="text-muted text-center">{{$user->bio}}</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">0</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">0</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">0</a>
                </li>
              </ul>

              <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

              <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">Malibu, California</p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
              <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
              <li><a href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                  <h1>No Activity Yet</h1>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <form class="form-horizontal" action="{{url('/admin/users')}}/{{$user->id}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT" />
                               <div class="form-group">
                    <label  class="col-sm-2 control-label"><strong> First Name</strong></label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ $name[0] }}"  type="text" placeholder="First Name" name="first_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-2 control-label"><strong> Last Name</strong></label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ $name[1] }}" type="text" placeholder="Last Name" name="last_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-2 control-label"><strong> Username</strong></label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input value="{{ $user->username }}" disabled="" type="text" placeholder="Username" name="username" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-sm-2 control-label"><strong> Email</strong></label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input value="{{ $user->email }}" required="" type="email" placeholder="Email" name="email" class="form-control">
                    </div>
                </div>




                <div class="form-group">
                    <label  class="col-sm-2 control-label"><strong> Bio</strong></label>
                   <div class="col-sm-9">
                    <textarea name="bio" class="textarea" placeholder="Place some text here" style="width: 100%; height: 190px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $user->bio }}</textarea>
                   </div>
                </div>
                @if($user->social == "0")
                <div class="form-group">
                    <label  class="col-sm-2 control-label"><strong>Old Password</strong></label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input   type="password" placeholder="Old Password" name="old_password" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-sm-2 control-label"><strong> New Password</strong></label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input   type="password" placeholder="New Password" name="password" class="form-control">
                    </div>
                </div>
               @endif
                <div class="form-group">
                    <label  class="col-sm-2 control-label"><strong> Phone</strong></label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input value="{{ $user->phone }}" type="text" placeholder="phone" name="phone" class="form-control">
                    </div>
                </div>
                           {{ csrf_field() }}
                  <div class="form-group">
                    <div class=" col-sm-9">
                      <button type="submit" class="btn btn-danger">Save</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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