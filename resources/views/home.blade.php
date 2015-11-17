@extends('app')

@section('content')

    <h1>Hello {{$user['name']}}</h1>

    <h3><a href="joinQueue">Join the Queue</a></h3>

    <div id="QueueCounter">

    </div>

@stop


@section('friendsList')
    <nav class="nav-sidebar sideBarRight">
        <ul class="nav">
            <li class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <a href=""><h4>Notifications <i class="glyphicon glyphicon-envelope"></i></h4></a>
            </li>
            <div id="collapseTwo" class="collapse">
                <li><a href="">Message 1</a></li>
                <li><a href="">Message 2</a></li>

            </div>


            <li class="nav-divider"></li>
            <li class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <a href=""><h4>FriendsList <i class="glyphicon glyphicon-heart-empty"></i></h4></a>
            </li>
            <div id="collapseThree" class="collapse">
                @for($i = 0;$i<Count($friendsList);$i++)
                    <h4>{{$friendsList[$i]['name']}} -
                        @if($friendsList[$i]['friendStatus'] == 0)Pending
                        @else <a href="">Invite to lobby</a>
                        @endif
                    </h4>
                @endfor
            </div>
            <li class="nav-divider"></li>
            <li class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <a href=""><h4>Find Friends <i class="glyphicon glyphicon-search"></i></h4></a>
            </li>
            <div id="collapseFour" class="collapse">
                <div class="input-group col-md-12">
                    <input type="text" id="friendSearch" name="friendSearch" class="search-query form-control" placeholder="Search" />
                    <span class="input-group-btn">
                        <button id="friendSearchButton" class="btn btn-danger" type="button">
                            <span class=" glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
                <div class="users">

                </div>

            </div>
            <li class="nav-divider"></li>
        </ul>
    </nav>

@stop

@section('theJavaScript')
    <script>
            var allUsers = <?php echo json_encode($allUsers); ?>;




            $('#friendSearchButton').click(function(){
                var searchValue = $('#friendSearch').val();
                var newHtml = [];
                for(var i = 0;i<allUsers.length;i++){
                    if(searchValue.toLowerCase().indexOf(allUsers[i]['name']) >= 0){
                        newHtml.push('<h4 id="user-'+allUsers[i]+'">'+allUsers[i]['name'] + ' - <a href="friendAdd/'+allUsers[i]['id']+'"> Add</a></h4>');
                    }
                }
                $(".users").html(newHtml.join(""));

            });






            function refresh_div() {
                jQuery.ajax({
                    url:'/countQueue',
                    type:'GET',
                    success:function(results) {
                        jQuery("#QueueCounter").html(results);
                    }
                });
            }

            t = setInterval(refresh_div,1000);

    </script>

@stop


