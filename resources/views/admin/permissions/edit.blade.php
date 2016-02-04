@extends('layouts/default')

@section('content')
@section('header_styles')
<link rel="stylesheet" href="{{asset('bower_components/AdminLTE/plugins/iCheck/all.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/AdminLTE/plugins/select2/select2.min.css')}}"/>
@endsection

<div class="box">
    <div class="box-header">


    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @include('admin/messages')
        <form action="{{url('/admin/permissions/')}}/{{$permission->id}}" method="POST" >

            <div class="col-md-6">

                <div class="form-group">
                    <label><strong>  Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ $permission->label }}"  type="text" placeholder="Name" name="name" class="form-control">
                    </div>
                </div>
                <div class="form-group">

                    <label>
                        <input id="attach" name="attach" type="checkbox" class="flat-red" >
                        <strong> Update & Attach to an Existing Role </strong>
                    </label>
                </div>

                @if(count($roles) > 0)
                <div class="form-group show-roles">
                    <label><strong> Attached Role(s)</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                        <select style="width:100%" multiple="" id="roles" name="roles[]" >
                            @foreach($roles as $role)
                            <option <?php if(@in_array($role->id, $permissionRoles)): ?> selected="selected" <?php endif;?> value="{{$role->id}}">{{$role->label}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @endif



                <br>
                <button type="submit" class="btn btn-success  btn-block" name="submit"><i class="fa fa-flag"></i> Update Permission</button>
            </div>
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT"/>

        </form>        
    </div>

</div>
<!-- /.box -->
<!-- DataTables -->
@section('footer_scripts')

<script src="{{asset('bower_components/AdminLTE/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('bower_components/AdminLTE/plugins/iCheck/icheck.min.js')}}"></script>
<script>
$(function () {

    $("select#roles").select2();

    $('input[type="checkbox"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
    });

    $('input[type="checkbox"].flat-red').iCheck('uncheck');

    $('input[type="checkbox"].flat-red').on('ifChecked', function (event) {
        $('div.show-roles').slideDown();
    });
    $('input[type="checkbox"].flat-red').on('ifUnchecked', function (event) {
        $('div.show-roles').slideUp();
    });




});
</script>

@endsection
@endsection