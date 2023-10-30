<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable{
    protected $table = 'users';
    protected $guarded = ['id'];
    public $timestamps = false;


    public static function getAllOtherUser(){
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
        }
        return self::where('id', '!=', $user_id)->get();
    }
}
