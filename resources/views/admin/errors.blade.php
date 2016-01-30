@if(count($errors) > 0)
<div class="alert alert-danger alert-dismissable">
    @foreach($errors as $error)
    <p> {{$error}} </p>
    @endforeach
</div>
@endif