@extends('layouts/default')

@section('content')

<div class="box">
    <div class="box-header">
        <a href="{{url('admin/users/create')}}" class="btn btn-primary"><span class="fa fa-user-plus"></span> Add User </a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @if(count($roles) > 0)
        <div class="role_search">
            <label><strong>Search By Role</strong></label>
            <select class="form-control" id="roles" name="roles">
                <option value="0">Select Role</option>
                @foreach($roles as $role)
                <option value="{{$role->id}}">{{$role->label}}</option>
                @endforeach
            </select>
        </div>

        @endif
        <table id="users" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
<!--                    <th>Avatar</th>-->
                    <th>Email</th>
                    <th>Created</th>

                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th>Username</th>
<!--                    <th>Avatar</th>-->
                    <th>Email</th>
                    <th>Created</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<!-- DataTables -->
@section('footer_scripts')
<script src="{{asset('bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script>
$(function () {
    var dataTable = $('#users').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('/') }}/admin/users/dataTables",
            data: function (params) {
                params.role = $("select#roles").val()
            }
        }
    });

    $('select#roles').on('change', function (e) {
        dataTable.draw();
        e.preventDefault();
    });
});
</script>
@endsection
@endsection