@extends('layouts/default')

@section('content')
@section('header_styles')

@endsection

<div class="box">
    @if(!empty($name))
    <div class="box-header">
        <h3>Add State to : <strong style="color:red">{{$name}}</strong></h3>
    </div>
    @endif
    <!-- /.box-header -->
    <div class="box-body">
        @include('admin/messages')
        <form action="{{url('/admin/states/')}}" method="POST" >
            <div class="col-md-6">

                <div class="form-group">
                    <label><strong>  Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ old('name') }}"  type="text" placeholder="Name" name="name" class="form-control">
                    </div>
                </div>
               
                <button type="submit" class="btn btn-success  btn-block" name="submit"><i class="fa fa-flag"></i> Create State</button>
            </div>
            {{ csrf_field() }}
            <input type="hidden" name="country_id" value="{{$id}}"/>



        </form>        
    </div>

</div>
<!-- /.box -->
<!-- DataTables -->
@section('footer_scripts')

@endsection
@endsection