@extends('app')

@section('leftSideBar')
    @include('includers/sideBarLeft')
@stop

@section('content')
    <div class="col-lg-12">

        @if($lobby)
                <div class="row theLobby col-lg-12">
                    <div class="col-lg-1"></div>
                    @for($i = 0; $i<5;$i++)
                        <div class="col-lg-2 dropdown">
                            <div class="thumbnail" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if($lobby[$i]['status'] == "leader_id")
                                Leader
                                @endif
                                <img src={{$lobby[$i]['imgSrc']}}>
                                {{$lobby[$i]['name']}}
                                    @if($lobby[$i]['id'] == 0)
                                        @if($lobby[$i]['status'] == "leader_id")
                                            <a class="btn btn-warning btn-xs" href=""> Become Leader</a>
                                        @else
                                            <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-success btn-xs">Invite Friend</button>
                                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                @foreach($friendsList as $friend)
                                                    Hello
                                                @endforeach
                                            </ul>
                                        @endif
                                    @else
                                        @if($lobby[5] == $user['id'])
                                            @if($lobby[$i]['id'] == $user['id'])
                                                <a href="leaveQueue/{{$user['id']}}" class="btn btn-info btn-xs">Leave Lobby</a>
                                            @else
                                                <a href="" class="btn btn-danger btn-xs">Kick Player</a>
                                            @endif

                                        @else
                                            @if($lobby[$i]['id'] == $user['id'])
                                                <a class="btn btn-info" href="leaveQueue/{{$user['id']}}">Leave Lobby</a>
                                            @endif
                                        @endif
                                    @endif
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="col-lg-2">

                </div>
        @endif
    </div>

    <div class="col-lg-12">
        <div class="col-lg-6 col-lg-offset-3">
            @if($lobby)
            <button type="button" class="btn btn-default btn-lg btn-block">Start Searching For A Game With Your Lobby</button>
            @else
            <a href="createALobby/{{$user['id']}}" type="button" class="btn btn-default btn-lg btn-block theButtons">Create a Lobby</a>
            <button type="button" class="btn btn-default btn-lg btn-block">Search For A Game</button>
            @endif
        </div>


    </div>










    @for($i = 0;$i<Count($notifications);$i++)

        <div class="modal fade" id="myModal{{$i}}" tabindex="-1" role="dialog" aria-labelledby="myModal{{$i}}Label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        @if($notifications[$i]['status'] == 0)
                        <a href="markAsRead/{{$notifications[$i]['id']}}" class="pull-left">Mark as read</a>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{$notifications[$i]['title']}}</h4>
                    </div>
                    <div class="modal-body">
                        {!! $notifications[$i]['body']!!}
                    </div>
                    <div class="modal-footer">
                        @if($notifications[$i]['type'] == 0)
                            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                <div class="btn-group" role="group">
                                    <a type="button" class="btn btn-success" href="friendAccept/{{$notifications[$i]['sender_id']}}">Accept friends Request</a>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-danger">Refuse friends Request</button>
                                </div>
                            </div>

                        @else
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endfor

@stop


@section('rightSideBar')
    @include('includers/sideBarRight')
@stop

@section('theJavaScript')
    <script>
            var allUsers = <?php echo json_encode($allUsers); ?>;

            $('#friendSearchButton').click(function(){
                var searchValue = $('#friendSearch').val();
                var newHtml = [];
                for(var i = 0;i<allUsers.length;i++){
                    if(searchValue.toLowerCase().indexOf((allUsers[i]['name']).toLowerCase()) >= 0){
                        newHtml.push('<h4 id="user-'+allUsers[i]+'">'+allUsers[i]['name'] + ' - <a href="friendAdd/'+allUsers[i]['id']+'"> Add</a></h4>');
                    }
                }
                if(newHtml.length >0){
                    $(".users").html(newHtml.join(""));
                }else{
                    $(".users").html("No User with that nickname");
                }


            });

            function doSomething() {
                window.location = "../myLogout";
            }

            window.onload = function () {
                setTimeout(doSomething, 3.6e+6); //Then set it to run again after ten minutes
            };






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


