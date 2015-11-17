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

            echo "<script>
        var friend = '<?php echo $friend ?>';

        alert('$friend ' + 'Added');
        window.location.href='../home';
        </script>";
        }


    }

    public function friendAddQuery($your_id, $friend_id){
        DB::table('friendslist')->insert(
            ['user_id' => $your_id,'friend_id' => $friend_id]
        );
        DB::table('friendsrequest')->insert(
            ['user_id' => $your_id,'friend_id' => $friend_id]
        );
    }

    public function friendAddYourSelf(){

        echo "<script>
        alert('You Can Not Add Your Self!');
        window.location.href='../home';
        </script>";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
