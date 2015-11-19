<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;


class homeController extends Controller
{

    public function index(Request $request){
        $us = Auth::user();

        $sessionData = $this->addingToTheSession($us['id']);

        $friendsList = $this->getFriendsList($us);

        $lobby = $this->getLobby($us['id']);
        $theLobby = $lobby[0]['id'];

        if($lobby){
            $lobby = $this->getNamesInLobby($lobby);
            for($i = 0;$i<5;$i++){
                if($lobby[$i]['status'] == "leader_id"){
                    $lobbyLeader = $lobby[$i]['id'];
                }
            }
            array_push($lobby,$lobbyLeader);
            array_push($lobby,$theLobby);
        }


        $notif = $this->getNotifications($us['id']);

        $allUsers = DB::table('users')->select('id','name')->get();
        $us['inLobby'] = false;

            return view('home',['user'=>$us,'lobby' => $lobby, 'friendsList'=>$friendsList ,'allUsers'=>$allUsers,'notifications'=>$notif,'usersInSession' => $sessionData]);

    }

    public function addingToTheSession($id){
        $theSession = DB::table('mysessions')
            ->where('user_id',$id)
            ->get();


        if(empty($theSession)){
            DB::table('mysessions')->insert(
                ['user_id' => $id,'status' => 1,'created_at' => Carbon::now(),'updated_at'=> Carbon::now()]
            );
        }else{
            DB::table('mysessions')
                ->where('user_id',$id)
                ->update(['status' => 1,'updated_at' => Carbon::now()]);
        }
        $theSession = DB::table('mysessions')->get();

        json_decode(json_encode($theSession), true);

        return $theSession;
    }

    public function getFriendsList($us)
    {

        $friendsListS = DB::table('friendslist')
            ->join('users','users.id', '=', 'friendslist.friend_id')
            ->select('users.name','friendslist.friendStatus','friendsList.friend_id')
            ->where('friendslist.user_id',$us['id'])
            ->get();

        return json_decode(json_encode($friendsListS), true);



    }


    public function getNotifications($id){
        $notif = DB::table('notifications')->select('id','title','body','type','sender_id','status')->where('user_id',$id)->get();

        return json_decode(json_encode($notif), true);
    }

    public function joinQueue(){
        $us = Auth::user();

        DB::table('lobby')->insert(
            ['user_id' => $us['id']]
        );

        return redirect('home');

    }


    public function friendSearchIndex()
    {
        return redirect('home');
    }

    public function markAsRead($note_id){
        DB::table('notifications')
            ->where('id',$note_id)
            ->update(['status' => 1]);

        return redirect('home');
    }


    public function getLobby($id){
        $arr = array('leader_id','second_id','third_id','forth_id','fifth_id');
        $found = 0;
        for($i = 0; $i<5; $i++){
            $lobby = DB::table('lobby')
                ->where($arr[$i], $id)
                ->get();
            if(json_decode(json_encode($lobby), true)){
                $found = json_decode(json_encode($lobby), true);
            }
        }

        return $found;
    }

    public function getNamesInLobby($lobby){
        $arr = array('leader_id','second_id','third_id','forth_id','fifth_id');
        $theArr = [];
        for($i = 0; $i<5; $i++) {
            $tempArr = [];
            $userName = DB::table('users')
                ->select('name','imgSrc')
                ->where('id',$lobby[0][$arr[$i]])
                ->get();
            if(!json_decode(json_encode($userName), true)){
                $userName['name'] = "Empty";
                $userName['imgSrc'] = "http://freestyledancepa.com/wp-content/uploads/2012/04/cf6e3c9d010d2af3871e72e49b85cbf6.png";
            }else{
                $userName = (json_decode(json_encode($userName[0]), true));
            }
            $userName['id'] = $lobby[0][$arr[$i]];
            $userName['status'] = $arr[$i];
            array_push($theArr,$userName);

        }
        return $theArr;
    }



    public function sessions(Request $request){
        //$request->session()->put('onlineUsers', 'Baldur');
        //$request->session()->forget('user');

        return redirect('home');
    }

}