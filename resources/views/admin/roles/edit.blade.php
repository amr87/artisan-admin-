@extends('layouts/default')

@section('content')
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/AdminLTE/plugins/select2/select2.min.css')}}"/>

@endsection

<div class="box">
    <div class="box-header">


    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @include('admin/errors')
        <form action="{{url('/admin/roles/')}}/{{$role->id}}" method="POST" >
          
            <div class="col-md-6">

                <div class="form-group">
                    <label><strong>  Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ $role->label }}"  type="text" placeholder="Name" name="name" class="form-control">
                    </div>
                </div>


                @if(count($permissions) > 0)
                <div class="form-group">
                    <label><strong> Permissions</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                        <select class="col-md-6" multiple="" id="roles" name="permissions[]">
                            @foreach($permissions as $permission)
                            <option <?php if(@in_array($permission->id, $permissionIds)): ?> selected="selected" <?php endif ?>value="{{$permission->id}}">{{$permission->label}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @endif
                <br>
                <button type="submit" class="btn btn-success  btn-block" name="submit"><i class="fa fa-flag"></i> Update Role</button>
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

<script>
$(function () {

    $("select#roles").select2();

});
</script>
@endsection
@endsection