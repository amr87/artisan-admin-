@extends('layouts/default')

@section('content')
@section('header_styles')

@endsection

<div class="box">
    
    <div class="box-header">
        @if(!empty($name))
        <h3>Add District to : <strong style="color:red">{{$name}}</strong></h3>
        @endif
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @include('admin/messages')
        <form action="{{url('/admin/districts/')}}" method="POST" >
            <div class="col-md-6">

                <div class="form-group">
                    <label><strong>  Name</strong></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-question"></i></span>
                        <input value="{{ old('name') }}"  type="text" placeholder="Name" name="name" class="form-control">
                    </div>
                </div>
               
                <button type="submit" class="btn btn-success  btn-block" name="submit"><i class="fa fa-flag"></i> Create District</button>
            </div>
            {{ csrf_field() }}
            <input type="hidden" name="state_id" value="{{$id}}"/>



        </form>        
    </div>

</div>
<!-- /.box -->
<!-- DataTables -->
@section('footer_scripts')

@endsection
@endsection