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
        <form action="{{url('/admin/roles/')}}" method="POST" >
            <div class="col-md-6">

                <div class="form-group">
                    <label><strong>  Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ old('name') }}"  type="text" placeholder="Name" name="name" class="form-control">
                    </div>
                </div>


                @if(count($permissions) > 0)
                <div class="form-group">
                    <label><strong> Permissions</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                        <select class="col-md-6" multiple="" id="roles" name="permissions[]">
                            @foreach($permissions as $permission)
                            <option value="{{$permission->id}}">{{$permission->label}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @endif

                <div class="form-group">

                    <label>
                        <input id="attach" name="attach" type="checkbox" class="flat-red" >
                        <strong> Create & Attach to an Existing User(s) </strong>
                    </label>
                </div>


                <div class="form-group show-roles">
                    <label><strong> Attached User(s)</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                        <select style="width:100%" multiple="" id="users" name="users[]" >

                        </select>
                    </div>
                </div>


                <button type="submit" class="btn btn-success  btn-block" name="submit"><i class="fa fa-flag"></i> Create Role</button>
            </div>
            {{ csrf_field() }}



        </form>        
    </div>

</div>
<!-- /.box -->
<!-- DataTables -->
@section('footer_scripts')
<script src="{{asset('bower_components/AdminLTE/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('bower_components/AdminLTE/plugins/iCheck/icheck.min.js')}}"></script>
<script>

function formatRepo(repo) {
    if (repo.loading)
        return repo.text;

    var markup = '<option value="' + repo.id + '">' + repo.username + '</option>';
    return markup;
}

function formatRepoSelection(repo) {
    return repo.username;
}
$(function () {

    $("select#roles").select2();
    $("select#users").select2({
        ajax: {
            url: "{{url('/admin/users/search')}}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });



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