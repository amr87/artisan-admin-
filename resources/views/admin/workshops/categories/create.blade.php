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
        @include('admin/messages')
        <form action="{{url('/admin/categories/')}}" method="POST" >
            <div class="col-md-6">

                <div class="form-group">
                    <label><strong>  Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ old('name') }}"  type="text" placeholder="Name" name="name" class="form-control">
                    </div>
                </div>


                @if(count($categories) > 0)
                <div class="form-group">
                    <label><strong> Parent Category</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                        <select style="width:100%"  id="categories" name="parent_id" >
                            <option value="null">N/A</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @endif

                <br>
                <button type="submit" class="btn btn-success  btn-block" name="submit"><i class="fa fa-flag"></i> Create Category</button>
            </div>
            {{ csrf_field() }}



        </form>        
    </div>

</div>
<!-- /.box -->
<!-- DataTables -->
@section('footer_scripts')
<script src="{{asset('bower_components/AdminLTE/plugins/select2/select2.full.min.js')}}"></script>

<script>
$(function () {

    $("select#categories").select2();


});
</script>
@endsection
@endsection