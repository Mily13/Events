<?php

namespace App\Http\Controllers;

use App\Models\JoiningModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoiningController extends Controller{
//    public function join(Request $request){
//        $event = $request->event;
//        $user = $request->user;
//
//        if ($user == 0){
//            return response()->json(['redirect' => route('login')]);
//        }
//
//        $joined = JoiningModel::isJoined($user, $event);
//
//        if ($joined){
//            return response()->json(['joined' => true]);
//        }else{
//            JoiningModel::create([
//                'event' => $event,
//                'user' => $user,
//            ]);
//            return response()->json(['joined' => false]);
//        }
//    }


    public static function delete(Request $request){
        if (Auth::check()) {
            $request->validate([
                'event' => 'required',
            ]);

            $event = $request->input('event');
            $user = Auth::user();
            $user_id= $user->id;

            JoiningModel::where('event', $event)->where('user', $user_id)->delete();

            return redirect()->route('profile');
        }else{
            return redirect()->route('login');
        }
    }
}
