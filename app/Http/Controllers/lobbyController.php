<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class lobbyController extends Controller
{

    public function inviteToLobbyAccept($user_id,$lobby_id){
        $lobby = DB::table('lobby')
                ->where('id',$lobby_id)
                ->get();

        $arr = array('leader_id','second_id','third_id','forth_id','fifth_id');
        $place = "Full";
        for($i = 0; $i<5; $i++){
            if($lobby[0]->{$arr[$i]} == 0){
            $place = $arr[$i];
            }
        }

        if($place == "Full"){

        }else{
            DB::table('lobby')
                ->where('id',$lobby_id)
                ->update([$place=>$user_id]);
        }



        return redirect('home');
    }

    public function inviteToLobby($user_id,$lobby_id){
        $you = Auth::user();

        $title = "Game Invite";
        $message = $you['name']." Invited you to his lobby<br>".'<a href=inviteToQueueAccept/'.$user_id.'/'.$lobby_id.'>AcceptTheGame?</a>';

        DB::table('notifications')->insert(
            ['user_id'=> $user_id,'title' => $title,'body' => $message,'sender_id' => $you['id'],'type' => 11]
        );

        return redirect('home');
    }


    public function leaveQueue($id){

        $lobby = $this->getLobby($id);
        $arr = array('leader_id','second_id','third_id','forth_id','fifth_id');

            DB::table('lobby')
                ->where($arr[$lobby], $id)
                ->update([$arr[$lobby] => 0]);
        return redirect('home');
    }


    public function getLobby($id){
        $arr = array('leader_id','second_id','third_id','forth_id','fifth_id');
        $number = 99;
        for($i = 0; $i<5; $i++){
            $lobby = DB::table('lobby')
                ->where($arr[$i], $id)
                ->get();
            if(json_decode(json_encode($lobby), true)){
                $number = $i;
            }
        }

        return $number;
    }

}


