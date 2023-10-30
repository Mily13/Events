<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\Event;
use App\Models\Joining;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{
    public function loginPage(){
        return view('login');
    }


    public function signupPage(){
        return view('signup');
    }


    public function login(Request $request){
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


    public function signup(SignupRequest $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $phone = $request->input('phone');
        $birthday = $request->input('birthday');

        $user = User::create([
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

            $events = Event::getUsersEvents($user_id);
            $event_id_array = Joining::getEventIds($user_id);
            $joined_events = Event::getJoinedEvents($event_id_array);

            return view('profile', compact('user', 'events', 'joined_events'));
        }else{
            return view('login');
        }
    }
}
