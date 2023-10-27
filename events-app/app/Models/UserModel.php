<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class UserModel extends Authenticatable{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'password', 'phone', 'birthday'];
    public $timestamps = false;


    public static function getAllOtherUser(){
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
        }
        return self::where('id', '!=', $user_id)->get();
    }
}
