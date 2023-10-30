<?php

namespace App\Http\Controllers;

use App\Models\Joining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoiningController extends Controller{
    public function delete(Request $request){
        if (Auth::check()) {
            $request->validate([
                'event' => 'required',
            ]);

            $event = $request->input('event');
            $user = Auth::user();
            $user_id= $user->id;

            Joining::where('event', $event)->where('user', $user_id)->delete();

            return redirect()->route('profile');
        }else{
            return redirect()->route('login');
        }
    }
}
