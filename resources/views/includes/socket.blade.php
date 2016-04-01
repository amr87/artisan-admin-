<!-- SOCKET IO -->
<script src="{{asset('js/socket.io.js')}}"></script>
<script>
var socket = new io.connect("{{getenv('SOCKET_URL')}}");
</script>
<script src="{{asset('js/receiver.js')}}"></script>
@if(Session::get('user_id'))
<script>
socket.on('connect', function () {
    socket.emit('sendId', {id: "{{ Session::get('user_id') }}", name: "{{ Session::get('user_data')['name']}}", avatar: "{{ Session::get('user_data')['avatar']}}"});
});
</script>
@endif
