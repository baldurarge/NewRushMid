<nav class="nav-sidebar sideBarRight">
    <ul class="nav">
        <li class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            <a href=""><h4>Notifications<i class="glyphicon glyphicon-bell"></i></h4></a>
        </li>
        <div id="collapseTwo" class="collapse in">
            @for($i = 0;$i<Count($notifications);$i++)
                <li id="modalToggler" type="button" data-toggle="modal" data-target="#myModal{{$i}}"><p class="text-info">{{$notifications[$i]['title']}} @if($notifications[$i]['status'] == 0)<span class="badge success"> New </span>@endif</p></li>
            @endfor
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
