<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingModel extends Model{
    protected $table = 'reading';
    protected $primaryKey = 'id';
    protected $fillable = ['user', 'event'];
    public $timestamps = false;


    public static function getEventIDs($user){
        return self::where('user', $user)->pluck('event')->toArray();
    }


    public static function getSelectedUsers($event){
        return self::where('event', $event)->pluck('user')->toArray();
    }
}
