@extends('layouts/default')

@section('content')

@section('header_styles')

@endsection

<div class="box">
    @include('admin/messages')

    <div class="box-header">

        @check("manage_users")
        <a href="{{url('admin/permissions/create')}}" class="btn btn-primary"><span class="fa  fa-user-plus"></span> Add Permission </a>
        @endcheck
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table id="permissions" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Created</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Label</th>
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
<script src="https://cdn.datatables.net/responsive/2.0.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.0.2/js/responsive.bootstrap.min.js"></script>
<script>
$(function () {

    var dataTable = $('#permissions').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "responsive": true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('/') }}/admin/permissions/dataTables",
        },
        columns: [
            {data: 'label', name: 'label'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
        ]
    });


});
function confirm_delete() {
    var confirm = window.confirm("Are you sure you want to delete this permission ?");
    return confirm ? true : false;
}
</script>
@endsection
@endsection