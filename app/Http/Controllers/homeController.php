<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use Auth;


class homeController extends Controller
{

    public function index(){
        $us = Auth::user();

        $friendsList = $this->getFriendsList($us);

        $lobby = $this->getLobby($us['id']);
        if($lobby){
            $lobby = $this->getNamesInLobby($lobby);
        }

        $notif = $this->getNotifications($us['id']);

        $allUsers = DB::table('users')->select('id','name')->get();
        $us['inLobby'] = false;

            return view('home',['user'=>$us,'lobby' => $lobby, 'friendsList'=>$friendsList ,'allUsers'=>$allUsers,'notifications'=>$notif]);

    }

    public function getFriendsList($us)
    {

        $friendsListS = DB::table('friendslist')
            ->join('users','users.id', '=', 'friendslist.friend_id')
            ->select('users.name','friendslist.friendStatus')
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

    public function leaveQueue(){
        $us = Auth::user();

        DB::table('lobby')->where('user_id', $us['id'])->delete();

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
                //$userName['name'] = $userName[0]['name'];
                $userName = (json_decode(json_encode($userName[0]), true));

            }
            $userName['id'] = $lobby[0][$arr[$i]];
            array_push($theArr,$userName);


        }
        return $theArr;
    }

}