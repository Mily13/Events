<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\JoiningModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{
    public static function loginPage(){
        return view('login');
    }


    public static function signupPage(){
        return view('signup');
    }


    public static function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials are not correct.',
        ])->onlyInput('email');
    }


    public static function signup(Request $request){
        $request->validate([
            'name' => 'required|string|max:99',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string',
            'birthday' => 'required|date',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $phone = $request->input('phone');
        $birthday = $request->input('birthday');

        $user = UserModel::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'phone' => $phone,
            'birthday' => $birthday,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }


    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard');
    }


    public function profile(){
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;

            $events = EventModel::getUsersEvents($user_id);
            $event_id_array = JoiningModel::getEventIds($user_id);
            $joined_events = EventModel::getJoinedEvents($event_id_array);

            return view('profile', compact('user', 'events', 'joined_events'));
        }else{
            return view('login');
        }
    }
}
