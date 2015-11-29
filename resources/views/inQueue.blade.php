@extends('app')


@section('leftSideBar')

@stop

@section('content')
    <h1 id="searchingH1">Searching for Players...<i id="searchingP">0</i></h1>
    <a>Stop seraching</a>

    <div id="ShoworNo">

    </div>
    <p id="TimeLeft"></p>
@stop


@section('rightSideBar')
    <div>
        <h4>Lobby</h4>
        @for($i = 0; $i<5;$i++)
            @if($lobby[$i]['id'] != 0)
                <h4>{{$lobby[$i]['name']}}</h4>
            @endif
        @endfor
    </div>
@stop

@section('theJavaScript')
    <script>
        var i = 0;
        var lobby_id = <?php echo $lobby[6]; ?>;

        var searching = true;

        function refresh_div(){
            if(searching){
                i++;
                $("#searchingP").html(i);
                if(i % 10 == 0){
                    jQuery.ajax({
                        url:'/countQueue/'+lobby_id,
                        type:'GET',
                        success:function(results) {
                            console.log(results);
                            if(results == "INGROUP"){
                                searching = false;
                                i = 0;
                            }
                        }
                    });


                }
            }else{
                i++;
                promptMessage(i);
            }

        }

        function promptMessage(number){
            if(number == 1){
                jQuery("#ShoworNo").html('<h1>Game Found!</h1><h3>Are You Ready?</h3><div class="text-center"><a>Yes!</a> or <a> Not Ready</a></div>');
                $("#searchingH1").html("WuHú");
            }else{
                jQuery("#TimeLeft").html(30-i);
            }

        }

                t = setInterval(refresh_div,1000);


        /*function refresh_div() {
         jQuery.ajax({
         url:'/countQueue',
         type:'GET',
         success:function(results) {
         jQuery("#QueueCounter").html(results);
         }
         });
         }

         t = setInterval(refresh_div,1000);
         */

    </script>

@stop