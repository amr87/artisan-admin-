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
        <form action="{{url('/admin/companies/')}}" method="POST" >
            <div class="col-md-6">

                <div class="form-group">
                    <label><strong>  Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ old('name') }}"  type="text" placeholder="Name" name="name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>  Email</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ old('email') }}"  type="email" placeholder="Email" name="email" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label><strong>  Address</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ old('address') }}"  type="text" placeholder="Address" name="address" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label><strong>  Phone</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ old('phone') }}"  type="text" placeholder="Phone" name="phone" class="form-control">
                    </div>
                </div>


             

                <br>
                <button type="submit" class="btn btn-success  btn-block" name="submit"><i class="fa fa-flag"></i> Create Company</button>
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