<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Carbon\Carbon;

class lobbyController extends Controller
{



    public function createLobby($user_id){
        DB::table('lobby')->insert(
            ['leader_id' => $user_id,'created_at' => Carbon::now(),'updated_at'=> Carbon::now()]
        );
        return redirect('home');
    }

    public function inviteToLobbyAccept($user_id,$lobby_id,$note_id){
        $lobby = DB::table('lobby')
                ->where('id',$lobby_id)
                ->get();
        $you = Auth::user();

        $arr = array('leader_id','second_id','third_id','forth_id','fifth_id');
        $place = "Full";
        for($i = 0; $i<5; $i++){
            if($lobby[0]->{$arr[$i]} == 0){
            $place = $arr[$i];
            }
        }
        for($i = 0; $i<5; $i++){
            if($lobby[0]->{$arr[$i]} == $user_id){
                $place = "InLobby";
            }
        }
        if($place == "Full"){
            DB::table('notifications')
                ->where('id',$note_id)
                ->update(['type' => 99]);

            $title = "Sorry Full!";
            $message = "The Lobby is full!";

            DB::table('notifications')->insert(
                ['user_id'=> $you['id'],'title' => $title,'body' => $message,'sender_id' => $user_id,'type' => 11]
            );

        }elseif($place == "InLobby"){

        }else{
            DB::table('lobby')
                ->where('id',$lobby_id)
                ->update([$place=>$user_id]);
            DB::table('notifications')
                ->where('id',$note_id)
                ->update(['type' => 99]);
        }



        return redirect('home');
    }

    public function inviteToLobby($user_id,$lobby_id){
        $you = Auth::user();

        $note_id = DB::table('notifications')
            ->max('id');

        $note_id = (int) $note_id;

        $title = "Game Invite";
        $message = $you['name']." Invited you to his lobby<br>".'<a href=inviteToQueueAccept/'.$user_id.'/'.$lobby_id.'/'.($note_id+1).'/>AcceptTheGame?</a>';

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


