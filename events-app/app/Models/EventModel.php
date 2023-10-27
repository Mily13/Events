<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventModel extends Model{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'date', 'location', 'image', 'type', 'description', 'creator', 'ispublic'];
    public $timestamps = false;


    public static function getPublicEventIDs(){
        return self::where('ispublic', true)->pluck('id')->toArray();
    }


    public static function getEvents($public, $personal){
        return self::whereIn('id', $public)->orWhereIn('id', $personal)->get();
    }


    public static function getFilteredEvents($public, $personal, $name, $datefrom, $dateto, $location, $type){
        $query = self::query();

        if ($name) {
            $query->where(function ($subquery) use ($name) {
                $subquery->where('name', 'like', "%$name%")
                    ->orWhere('description', 'like', "%$name%");
            });
        }

        if ($datefrom) {
            $query->where('date', '>=', $datefrom);
        }

        if ($dateto) {
            $query->where('date', '<=', $dateto);
        }

        if ($location) {
            $query->where('location', 'like', "%$location%");
        }

        if ($type != "Any") {
            $query->where('type', $type);
        }

        $events = $query->whereIn('id', $public)->orWhereIn('id', $personal)->get();

        return $events;
    }


    public static function getUsersEvents($user_id){
        return self::where('creator', $user_id)->get();
    }


    public static function getJoinedEvents($event_id_array){
        return self::whereIn('id', $event_id_array)->get();
    }


    public static function getEventIdByAttributes($name, $location, $date, $description, $type){
        return self::where('name', $name)
                    ->where('location', $location)
                    ->where('date', $date)
                    ->where('description', $description)
                    ->where('type', $type)
                    ->pluck('id')
                    ->first();
    }

}
