<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class userInfoController extends Controller
{


    public function showInfo($id){
        $user = $this->getUser($id);

        $userYou = Auth::user()->id;


        if(empty($user['twitch'])){
            $user['twitch'] = "Null";
        }
        if(empty($user['youtube'])){
            $user['youtube'] = "Null";
        }





        return view('userInfo',['user' => $user,'userYou' => $userYou]);
    }

    public function sendMessage($id,Request $request){
        $you = Auth::user();

        $title = $request->input('textTitle');
        $message = $request->input('message');

        DB::table('notifications')->insert(
            ['user_id'=> $id,'title' => $title,'body' => $message,'sender_id' => $you['id'],'type' => 11]
        );

        return redirect('home');
    }



    public function editUser($id){

        $userYou = Auth::user()->id;
        if($userYou != $id){
            return redirect('home');
        }else{

            $user = $this->getUser($id);



            return view('userEdit',['user' => $user]);
        }

    }

    public function getUser($id){


        $user = DB::table('users')
            ->where('id',$id)
            ->get();

         return json_decode(json_encode($user[0]), true);
    }

    public function update($id, Request $request)
    {
        $user = $this->getUser($id);
        $user['imgSrc'] = $request->input('imgSorce');
        $user['name'] = $request->input('nickname');
        $user['youtube'] = $request->input('youtube');
        $user['twitch'] = $request->input('twitch');
        $this->updateQuery($user);
        return redirect('home');

    }

    public function updateQuery($user){

        DB::table('users')
            ->where('id',$user['id'])
            ->update(['name' => $user['name'],'imgSrc' => $user['imgSrc'],'youtube' => $user['youtube'],'twitch' => $user['twitch']]);
    }
}
