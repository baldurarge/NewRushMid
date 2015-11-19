<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function friendAdd($friend_id)
    {
        $you = Auth::user();
        $friend = DB::table('users')->where('id', $friend_id)->value('name');


        if($friend === $you['name']){
            $this->friendAddYourSelf();
        }else{
            $this->friendAddQuery($you['id'],$friend_id);
            $this->sendNotification($friend_id,$you['name'],$you['id']);
            $this->messageFriendAdded($friend);
        }


    }

    public function friendAddQuery($your_id, $friend_id){
        DB::table('friendslist')->insert(
            ['user_id' => $your_id,'friend_id' => $friend_id]
        );



    }

    public function messageFriendAdded($friend){
        echo "<script>
        var friend = '<?php echo $friend ?>';

        alert('$friend ' + 'Added');
        window.location.href='../home';
        </script>";
    }

    public function sendNotification($friend_id,$senderName,$senderId){
        DB::table('notifications')->insert(
            ['user_id'=> $friend_id,'title' => "Friends Request",'body' => "You have a friend Request from ".$senderName,'sender_id' => $senderId]
        );
    }

    public function friendAddYourSelf(){

        echo "<script>
        alert('You Can Not Add Your Self!');
        window.location.href='../home';
        </script>";
    }

    public function friendAccept($id){
        $you = Auth::user();
        $this->friendAddQuery($you['id'],$id);
        $this->changeFriendStatus($you['id'],$id);

        return redirect('home');
    }

    public function changeFriendStatus($yourId,$friendId){
        DB::table('friendslist')
            ->where('user_id', $yourId)
            ->where('friend_id', $friendId)
            ->update(['friendStatus' => 1]);

        DB::table('friendslist')
            ->where('user_id', $friendId)
            ->where('friend_id', $yourId)
            ->update(['friendStatus' => 1]);
    }

}
