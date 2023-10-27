<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoiningModel extends Model{
    protected $table = 'joining';
    protected $primaryKey = 'id';
    protected $fillable = ['user', 'event'];
    public $timestamps = false;


    public static function getEventIds($user_id){
        return self::where('user', $user_id)->pluck('event')->toArray();
    }


    public static function isJoined($user, $event){
        return self::where('user', $user)->where('event', $event)->exists();
    }
}
