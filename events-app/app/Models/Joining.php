<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Joining extends Model{
    protected $table = 'joining';
    protected $guarded = ['id'];
    public $timestamps = false;


    public static function getEventIds($user_id){
        return self::where('user', $user_id)->pluck('event')->toArray();
    }


    public static function isJoined($user, $event){
        return self::where('user', $user)->where('event', $event)->exists();
    }


    public static function getEventsJoinedByUser($user){
        return self::where('user', $user)->pluck('event')->toArray();
    }
}
