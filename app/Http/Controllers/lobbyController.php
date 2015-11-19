<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class lobbyController extends Controller
{

    public function inviteToLobby($id,$place){
        echo $id;
        echo $place;

    }


    public function leaveQueue($id){

        $lobby = $this->getLobby($id);
        $arr = array('leader_id','second_id','third_id','forth_id','fifth_id');

            DB::table('lobby')
                ->where($arr[$lobby], $id)
                ->update([$arr[$lobby] => 0]);
        print_r($arr[$lobby]);
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


