@extends('app')

@section('content')
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2" >
              <div id="messages" ></div>
            </div>
        </div>
    </div>
    <script>
        var socket = io.connect('https://localhost:8890');

        socket.on('message', function (data) {
            $( "#messages" ).append( "<p>"+data+"</p>" );
          });


        $(function() {
            $("#btnLogin").click(function() {
                console.log('btn');
                socket.emit("create_user", {
                    id: '2342342',
                    name: 'ssdfess'
                });
            });

            socket.on('create_user',function(data){
                console.log('data',data);
            });
        });

    </script>

    <button type="button" id="btnLogin" class="btn btn-warning btn-lg btn-block">시작하기</button>


@endsection