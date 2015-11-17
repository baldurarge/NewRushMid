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

        $userInQueue = DB::table('lobby')->where('user_id', $us['id'])->first();
        $us['inLobby'] = false;
        if(count($userInQueue)>0){
            $us['inLobby'] = true;
        }


        if($us['inLobby']){
            return view('inQueue');
        }else{
            return view('home',['user'=>$us,'count'=>$this->CountQueue()]);
        }
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
        return view('friendSearch');
    }

}
