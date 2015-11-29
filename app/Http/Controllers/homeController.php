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
    public $arr = array('leader_id','second_id','third_id','forth_id','fifth_id');

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


        $searching = $this->checkingIfSearching($lobby[6]);



        $notif = $this->getNotifications($us['id']);

        $allUsers = DB::table('users')->select('id','name')->get();
        $us['inLobby'] = false;
            if($searching)
            {
                return view('inQueue',[
                   'user' => $us,
                    'lobby' => $lobby
                ]);
            }else{
                return view('home',[
                    'user'=>$us,
                    'lobby' => $lobby,
                    'friendsList'=>$friendsList,
                    'allUsers'=>$allUsers,
                    'notifications'=>$notif,
                    'usersInSession' => $sessionData
                ]);
            }


    }

    public function checkingIfSearching($lobby_id){
        $searcher = DB::table('lobbysearch')
            ->where('lobby_id',$lobby_id)
            ->get();
        if(empty($searcher)){
            return null;
        }else{
            return $searcher;
        }
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
        return redirect('home');
    }


    public function countQueue($lobby_id){
        $howMany = $this->getHowManySearching($lobby_id);


        $many = $howMany[0]->{'how_many'};
        $lobby_id = $howMany[0]->{'lobby_id'};
        $theLobby = DB::table('lobby')
            ->where('id',$lobby_id)
            ->get();

        $theIDS = $this->getUserIdFromLobby($theLobby);
        for($i = 0; $i<count($theIDS); $i++){
            $msg = $this->checkIfInFinalLobby($theIDS[$i]);
        }
        if($msg == "OK"){
            return $this->runThroughSearchingLobbys($many,$lobby_id,$howMany[0]);
        }else{
            return "INGROUP";
        }


    }

    public function getHowManySearching($lobby_id){
        $howMany = DB::table('lobbysearch')
            ->where('lobby_id',$lobby_id)
            ->get();

        return $howMany;
    }

    public function runThroughSearchingLobbys($howMany,$lobby_id,$yourLobby){
        switch ($howMany) {
            case 5:

        break;
            case 4:
                $any = $this->goThroughLobbySearch(1,$lobby_id,1);
                if(empty($any)){
                    return "Nothing";
                }else{
                    array_push($any,$yourLobby);
                    $this->foundLobbySearch($any);
                }

        break;
            case 3:
                $any = $this->goThroughLobbySearch(2,$lobby_id,1);
                if(empty($any)){
                    $any = $this->goThroughLobbySearch(1,$lobby_id,2);
                    if(empty($any)){
                        return "Nothing";
                    }else{
                        if(count($any) == 2){
                            array_push($any,$yourLobby);
                            $this->foundLobbySearch($any);
                        }else{
                            return "Nothing";
                        }
                    }
                }else{
                    array_push($any,$yourLobby);
                    $this->foundLobbySearch($any);
                }
        break;
            case 2:
                $any = $this->goThroughLobbySearch(2,$lobby_id,1);
                if(empty($any)){
                    $any = $this->goThroughLobbySearch(1,$lobby_id,3);
                    if(count($any) >= 3){
                        array_push($any,$yourLobby);
                        $this->foundLobbySearch($any);;
                    }else{
                        return "Nothing";
                    }
                }else{
                    $any1 = $this->goThroughLobbySearch(1,$lobby_id,1);
                    if(empty($any1)){
                        return "Nothing";
                    }else{
                        array_push($any,$any1);
                        array_push($any,$yourLobby);
                        $this->foundLobbySearch($any);

                    }
                }
        break;
            case 1:

                $any = $this->goThroughLobbySearch(1,$lobby_id,4);
                if(count($any)>= 4){
                    array_push($any,$yourLobby);
                    $this->foundLobbySearch($any);
                }else{
                    return "Nothing";
                }
        break;
            default:
                return "Def";

        }
    }

    public function goThroughLobbySearch($number,$lobby_id,$howMany){
        $any = DB::table('lobbysearch')
            ->where('how_many',$number)
            ->whereNotIn('lobby_id',[$lobby_id])
            ->take($howMany)
            ->get();

        return $any;
    }

    public function getYourLobbySerach($lobby_id){
        $any = DB::table('lobbysearch')
            ->where('lobby_id',$lobby_id)
            ->get();

        return $any;
    }


    public function foundLobbySearch($lobbys){
        $theids = $this->getUsersInAllLobbys($lobbys);

        $isItOk = "OK";

        for($i = 0; $i<5;$i++){
            $isItOk = $this->checkIfInFinalLobby($theids[$i][0]);
        }
        /*foreach($theids as $id){
            $isItOk = $this->checkIfInFinalLobby($id[0]);
        }*/

        if($isItOk == "OK"){
            $this->putInFinalLobby($theids);
        }else{
            return "INGROUP";
        }

        //$this->getUsersInAllLobbys($lobbys);
    }

    private function checkIfInFinalLobby($id){

        $finalLobby = DB::table('lobbyfinal')
            ->where($this->arr[0],$id)
            ->orWhere($this->arr[1],$id)
            ->orWhere($this->arr[2],$id)
            ->orWhere($this->arr[3],$id)
            ->orWhere($this->arr[4],$id)
            ->get();
        if(empty($finalLobby)){
            return "OK";
        }else{
            return "NO";
        }
    }

    private function putInFinalLobby($ids){
        DB::table('lobbyfinal')->insert(
            [$this->arr[0] => $ids[0][0],$this->arr[1] => $ids[1][0],$this->arr[2] => $ids[2][0],$this->arr[3] => $ids[3][0],$this->arr[4] => $ids[4][0],'created_at' => Carbon::now(),'updated_at'=> Carbon::now()]
        );
        return "INGROUP";
    }

    public function getUsersInAllLobbys($lobbys){
        $the_ids = [];

        foreach($lobbys as $lobby){
            $theLobby = DB::table('lobby')
                ->where('id',$lobby->{'lobby_id'})
                ->get();
            array_push($the_ids,$this->getUserIdFromLobby($theLobby));
        }

        return $the_ids;

    }

    private function getUserIdFromLobby($lobby){
        $returner = [];
        for($i = 0; $i<5;$i++){
            if($lobby[0]->{$this->arr[$i]} != 0){
                array_push($returner,$lobby[0]->{$this->arr[$i]});
            }
        }

        return $returner;
    }


}