<?php

use DB;

Class SearchForPlayers {

    public function __construct($lobby_id)
    {
        $howMany = DB::table('lobbysearch')
            ->where('lobby_id',$lobby_id)
            ->get();

        print_r($howMany);
    }
}