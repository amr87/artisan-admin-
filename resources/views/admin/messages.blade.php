@if(count($errors) > 0)
<div class="alert alert-danger alert-dismissable">
    @foreach($errors as $error)
    <p> {{$error}} </p>
    @endforeach
</div>
@elseif(@$success !== NUll)
<div class="alert alert-success alert-dismissable">
    <p>{{@$success}}</p>
</div>
@endif