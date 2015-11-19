@extends('app')

<style>
    .theWholeThing{
        margin-top: 3%;
    }
    .userInfoDiv{
        height:100%;
    }
</style>
<div class="theWholeThing">
@section('leftSideBar')
    @include('includers/sideBarLeft')
@stop

@section('content')


    <div class="userInfoDiv">
        <div class=" col-lg-7 col-md-6 col-sm-8 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <h1>{{$user['name']}}</h1>
                </div>
                <div class="panel-body collapse in" id="collapseTwo">
                    <div class="text-center">
                        <img src="{{$user['imgSrc']}}" class="img-rounded" style="width:150px;">
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <hr>
                        <div class="form-group">

                            <label class="col-lg-2 col-md-3 col-sm-3 col-xs-3 control-label">Email:</label>
                            <label class="col-lg-10 col-md-9 col-sm-9 col-xs-9">{{$user['email']}}</label>

                            <label class="col-lg-2 col-md-3 col-sm-3 col-xs-3 control-l abel">youtube:</label>
                            <label class="col-lg-10 col-md-9 col-sm-9 col-xs-9">@if($user['youtube'] != "Null")<a href="{{$user['youtube']}}">{{$user['name']}}'s Youtube Profile!</a>@else No youtube channel @endif</label>

                            <label class="col-lg-2 col-md-3 col-sm-3 col-xs-3 control-label">Twitch:</label>
                            <label class="col-lg-10 col-md-9 col-sm-9 col-xs-9">@if($user['twitch'] != "Null")<a href="{{$user['twitch']}}">{{$user['name']}}'s Twitch Profile!</a>@else No twitch channel @endif</label>
                            <label class="col-lg-2 col-md-3 col-sm-3 col-xs-3 control-label">Joined:</label>
                            <label class="col-lg-10 col-md-9 col-sm-9 col-xs-9">{{$user['created_at']}}</label>
                            <hr class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        </div>
                    </div>
                </div>
                @if($user['id'] == $userYou)
                    <div class="text-center">
                        <a class="btn btn-default" href="../userEdit/{{$userYou}}">Edit user info</a>
                    </div>
                @else
                    <div class="panel-footer text-center collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse" aria-expanded="false" aria-controls="collapse">
                        <h4>Send A Message</h4>
                    </div>
                    <div class="panel-body collapse" id="collapse">
                        <form action="../sendMessage/{{$user['id']}}" method="POST">
                            {!! csrf_field() !!}
                            <i>Title</i>
                            <input type="text" placeholder="Title" name="textTitle" id="textTitle">
                            <textarea class="form-control" rows="10" name="message" id="message"></textarea>
                            <button type="submit">Send Message</button>
                        </form>
                    </div>
                @endif


            </div>
        </div>
    </div>

@stop

</div>