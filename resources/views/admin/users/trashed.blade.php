@extends('layouts/default')

@section('content')

@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/AdminLTE/plugins/select2/select2.min.css')}}"/>
@endsection

<div class="box">
    @include('admin/messages')

    <div class="box-header">
 <a href="{{url('admin/users')}}" class="btn btn-primary"><span class="fa  fa-user"></span> Show Users </a>

    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @if(count($roles) > 0)
        <div class="form-group">
            <label><strong>Search By Role</strong></label>
            <select  id="roles" name="roles">
                <option value="0">Select Role</option>
                @foreach($roles as $role)
                <option value="{{$role->id}}">{{$role->label}}</option>
                @endforeach
            </select>
        </div>


        @endif
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table id="trsahedUsers" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Avatar</th>
                        <th>Email</th>
                        <th>Role(s)</th>
                        <th>Created</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Username</th>
                        <th>Avatar</th>
                        <th>Email</th>
                        <th>Role(s)</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
<!-- /.box -->
<!-- DataTables -->
@section('footer_scripts')
<script src="{{asset('bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('bower_components/AdminLTE/plugins/select2/select2.full.min.js')}}"></script>
<script>
$(function () {

    $("select#roles").select2();


    var dataTable = $('#trsahedUsers').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('/') }}/admin/users/trashedDataTables",
            data: function (params) {
                params.role = $("select#roles").val()
            }
        },
        columns: [
            {data: 'username', name: 'Username'},
            {data: 'avatar', name: 'Avatar'},
            {data: 'email', name: 'Email'},
            {data: 'bio', name: 'bio'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'}
        ]
    });

    $('select#roles').on('change', function (e) {
        dataTable.draw();
        e.preventDefault();
    });

});

 function confirm_delete(){
     var confirm  = window.confirm("Are you sure you want to delete this user ?");
     return confirm ? true : false;
 }
</script>
@endsection
@endsection