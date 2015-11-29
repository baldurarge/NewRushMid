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
    public $arr = array('leader_id','second_id','third_id','forth_id','fifth_id');



    public function createLobby($user_id){
        $this->setYourSelfInNewLobby($user_id);
        return redirect('home');
    }

    public function setYourSelfInNewLobby($user_id){
        DB::table('lobby')->insert(
            ['leader_id' => $user_id,'created_at' => Carbon::now(),'updated_at'=> Carbon::now()]
        );
    }

    public function inviteToLobbyAccept($user_id,$lobby_id,$note_id){
        $lobby = DB::table('lobby')
                ->where('id',$lobby_id)
                ->get();
        $you = Auth::user();


        $place = "Full";
        for($i = 0; $i<5; $i++){
            if($lobby[0]->{$this->arr[$i]} == 0){
            $place = $this->arr[$i];
            }
        }
        for($i = 0; $i<5; $i++){
            if($lobby[0]->{$this->arr[$i]} == $user_id){
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


            DB::table('lobby')
                ->where($this->arr[$lobby], $id)
                ->update([$this->arr[$lobby] => 0]);
        return redirect('home');
    }

    public function beLeader($id,$lobby_id){
        $lobby = $this->getLobby($id);

        $leader = DB::table('lobby')
            ->where('id',$lobby_id)
            ->get();

        $leader = json_decode(json_encode($leader), true);;

        if($leader[0]['leader_id'] == 0){
            DB::table('lobby')
                ->where($this->arr[$lobby], $id)
                ->update([$this->arr[$lobby] => 0]);

            DB::table('lobby')
                ->where('id', $lobby_id)
                ->update(['leader_id' => $id]);
        }

        return redirect('home');


    }


    public function getLobby($id){

        $number = 99;
        for($i = 0; $i<5; $i++){
            $lobby = DB::table('lobby')
                ->where($this->arr[$i], $id)
                ->get();
            if(json_decode(json_encode($lobby), true)){
                $number = $i;
            }
        }

        return $number;
    }

    public function startLookingWithGroup($lobby_id){

        $lobby = DB::table('lobby')
            ->where('id',$lobby_id)
            ->get();
        $lobby = json_decode(json_encode($lobby), true);
        $count = 0;
        for($i = 0; $i<5; $i++){
            if($lobby[0][$this->arr[$i]] != 0){
                $count++;
            }
        }
        $this->setYourLobbyInLobbySearch($lobby_id,$count);

        return redirect('home');



    }

    public function setYourLobbyInLobbySearch($loby_id,$count){
        DB::table('lobbySearch')->insert(
            ['lobby_id'=> $loby_id,'how_many' => $count,'created_at' => Carbon::now(),'updated_at'=> Carbon::now()]
        );
    }


}


