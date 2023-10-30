<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model{
    protected $table = 'events';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function creator(): HasOne{
        return $this->hasOne(User::class, 'creator');
    }


    public static function getPublicEventIDs(){
        return self::where('ispublic', true)->pluck('id')->toArray();
    }


    public static function getOwnEventIDs($creator){
        return self::where('creator', $creator)->pluck('id')->toArray();
    }


    public static function getEvents($public, $personal, $own){
        return self::whereIn('id', $public)
                    ->orWhereIn('id', $personal)
                    ->orWhereIn('id', $own)->get();
    }


    public static function getFilteredEvents($public, $personal, $own, $name, $dateFrom, $dateTo, $location, $type){
        $query = self::query();

        if ($name) {
            $query->where(function ($subquery) use ($name) {
                $subquery->where('name', 'like', "%$name%")
                    ->orWhere('description', 'like', "%$name%");
            });
        }

        if ($dateFrom) {
            $query->where('date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->where('date', '<=', $dateTo);
        }

        if ($location) {
            $query->where('location', 'like', "%$location%");
        }

        if ($type != "Any") {
            $query->where('type', $type);
        }

        $events = $query->where(function ($subquery) use ($public, $personal, $own) {
            $subquery->whereIn('id', $public)
                    ->orWhereIn('id', $personal)
                    ->orWhereIn('id', $own);
        })->get();

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
