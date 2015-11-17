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




        $userInQueue = DB::table('lobby')->where('user_id', $us['id'])->first();
        $allUsers = DB::table('users')->select('id','name')->get();
        $us['inLobby'] = false;
        if(count($userInQueue)>0){
            $us['inLobby'] = true;
        }

        if($us['inLobby']){
            return view('inQueue');
        }else{
            return view('home',['user'=>$us,'count'=>$this->CountQueue(),'friendsList'=>$friendsList ,'allUsers'=>$allUsers]);
        }
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

    public function countQueue(){

        return DB::table('lobby')->value('id');
    }

    public function friendSearchIndex()
    {
        return redirect('home');
    }

}
