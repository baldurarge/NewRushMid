<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Carbon\Carbon;

class myRoutingController extends Controller
{

    public function logout(){
        $id = Auth::user();

        DB::table('mysessions')
            ->where('user_id',$id['id'])
            ->update(['status' => 0,'updated_at' => Carbon::now()]);

        return redirect('../auth/logout');
    }

    public function login(){


    }
}
