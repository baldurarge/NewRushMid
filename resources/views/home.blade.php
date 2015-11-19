@extends('app')

@section('leftSideBar')
    @include('includers/sideBarLeft')
@stop

@section('content')
    <div class="col-lg-12">
        @if($lobby)
                <div class="row theLobby col-lg-10 col-lg-offset-2">
                    @for($i = 0; $i<5;$i++)
                        <div class="col-lg-2 dropdown">
                            <a href="" class="thumbnail" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if($lobby[$i]['status'] == "leader_id")
                                Leader
                                @endif
                                <img src={{$lobby[$i]['imgSrc']}}>
                                {{$lobby[$i]['name']}}
                            </a>
                            <ul class="dropdown-menu @if($lobby[$i]['id'] != 0)lobbyDropDown @endif" aria-labelledby="dLabel">
                                @if($lobby[$i]['id'] == 0)
                                    @if($lobby[$i]['status'] == "leader_id")
                                        <a class="btn btn-warning">Become Leader</a>
                                    @else
                                        <label>Invite Player</label>
                                        @for($b = 0;$b<Count($friendsList);$b++)
                                            <h4>
                                                @if($friendsList[$b]['friendStatus'] == 0)
                                                @else
                                                    @foreach($usersInSession as $userInSession)
                                                        @if($userInSession->{'user_id'} == $friendsList[$b]['friend_id'])
                                                            @if($userInSession->{'status'} == 1)
                                                                <a href="inviteToLobby/{{$friendsList[$b]['friend_id']}}/{{$lobby[6]}}">{{$friendsList[$b]['name']}}</a>
                                                            @else
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </h4>
                                        @endfor

                                    @endif
                                @else
                                    @if($lobby[5] == $user['id'])
                                        @if($lobby[$i]['id'] == $user['id'])
                                            <a class="btn btn-info" href="leaveQueue/{{$user['id']}}">Leave Lobby</a>
                                        @else
                                            <a class="btn btn-danger">Kick Player</a>
                                        @endif

                                    @else
                                        @if($lobby[$i]['id'] == $user['id'])
                                            <a class="btn btn-info" href="leaveQueue/{{$user['id']}}">Leave Lobby</a>
                                        @endif
                                    @endif
                                @endif

                            </ul>
                        </div>
                    @endfor
                </div>
                <div class="col-lg-2">

                </div>

        @else
            <div>
                <a class="btn btn-default">Create A Lobby</a>
            </div>
        @endif
    </div>

    <div class="col-lg-12">
        <h1>Hello {{$user['name']}}</h1>


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


