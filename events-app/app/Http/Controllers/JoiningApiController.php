<?php

namespace App\Http\Controllers;

use App\Models\Joining;
use Illuminate\Http\Request;

class JoiningApiController extends Controller{
    public function join(Request $request){
        $event = $request->event;
        $user = $request->user;

        if ($user == 0){
            return response()->json(['redirect' => route('login')]);
        }

        $joined = Joining::isJoined($user, $event);

        if ($joined){
            return response()->json(['joined' => true]);
        }else{
            Joining::create([
                'event' => $event,
                'user' => $user,
            ]);
            return response()->json(['joined' => false]);
        }
    }
}
