@if( session('errors') && count(session('errors')) > 0)
<div class="alert alert-danger alert-dismissable" role='alert'>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    @foreach( session('errors') as $error)
    <p class="text"> <i class="fa fa-lg fa-warning"></i> {{$error}} </p>
    @endforeach
</div>
@elseif( session('success'))
<div class="alert alert-success alert-dismissable" role='alert'>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <p class="text"><i class="fa fa-lg fa-check-circle"></i> {{session('success')}}</p>
</div>
@endif