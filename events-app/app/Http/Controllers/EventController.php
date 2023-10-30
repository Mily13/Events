<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Joining;
use App\Models\Reading;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller{
    public function getEvents(){
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;

            $ownEventsArray = Event::getOwnEventIDs($user_id);
            $personalEventsArray = Reading::getEventIDs($user_id);

            $joinedEventsArray = Joining::getEventsJoinedByUser($user_id);
        }else{
            $ownEventsArray = [];
            $personalEventsArray = [];
            $joinedEventsArray = [];
            $user_id = 0;
        }

        $publicEventsArray = Event::getPublicEventIDs();
        $events = Event::getEvents($publicEventsArray, $personalEventsArray, $ownEventsArray);


        return view('dashboard', compact('events', 'user_id', 'joinedEventsArray', 'ownEventsArray'));
    }


    public function getEventsFiltered(Request $request){
        $request->validate([
            'name' => 'max:99',
            'location' => 'max:99',
            'type' => 'max:99',
        ]);

        $name = $request->input('name');
        $dateFrom = $request->input('datefrom');
        $dateTo = $request->input('dateto');
        $location = $request->input('location');
        $type = $request->input('type');

        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;

            $ownEventsArray = Event::getOwnEventIDs($user_id);
            $personalEventsArray = Reading::getEventIDs($user_id);

            $joinedEventsArray = Joining::getEventsJoinedByUser($user_id);
        }else{
            $ownEventsArray = [];
            $personalEventsArray = [];
            $joinedEventsArray = [];
            $user_id = 0;
        }

        $publicEventsArray = Event::getPublicEventIDs();
        $events = Event::getFilteredEvents($publicEventsArray, $personalEventsArray, $ownEventsArray, $name, $dateFrom, $dateTo, $location, $type);

        return view('dashboard', compact('events', 'user_id', 'joinedEventsArray', 'ownEventsArray'));
    }


    public function eventForm(){
        if (Auth::check()) {
            $users = User::getAllOtherUser();
            return view('addEvent', compact('users'));
        }
        return back()->withErrors([
            'error' => 'You have to login to create an Event',
        ]);
    }


    public function modifyForm(Request $request){
        $request->validate([
            'event' => 'required',
        ]);

        $users = User::getAllOtherUser();
        $event_id = $request->input('event');
        $event = Event::where('id', $event_id)->first();
        $selectedUsers = Reading::getSelectedUsers($event_id);

        return view('modifyEvent', compact('event', 'users', 'selectedUsers'));
    }


    public function insert(EventRequest $request){
        $name =  $request->input('name');
        $date = $request->input('date');
        $location =  $request->input('location');
        $type =  $request->input('type');
        $description = $request->input('description');
        $isPublic = $request->input('ispublic');

        if ($isPublic == 'private'){
            $isPublic = 0;
        }else{
            $isPublic = 1;
        }

        if (Auth::check()) {
            $user = Auth::user();
            $creator = $user->id;
        }


        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $image = $request->file('image');

                $imagePath = $image->store('images', 'public');
            } else {
                return back()->withErrors([
                    'error' => 'Error uploading image. Please check the file format and try again!',
                ]);
            }
        }else {
            $imagePath = null;
        }

        Event::create([
            'name' => $name,
            'date' => $date,
            'location' => $location,
            'image_path' => $imagePath,
            'type' => $type,
            'description' => $description,
            'creator' => $creator,
            'ispublic' => $isPublic,
        ]);

        $event_id = Event::getEventIdByAttributes($name, $location, $date, $description, $type);

        if ($isPublic == 0){
            $users = $request->input('users', []);
            foreach ($users as $user) {
                Reading::create([
                    'user' => $user,
                    'event' => $event_id,
                ]);
            }
        }

        return redirect()->route('dashboard');
    }


    public function update(EventRequest $request){
        $id = $request->input('id');
        $name =  $request->input('name');
        $date = $request->input('date');
        $location =  $request->input('location');
        $type =  $request->input('type');
        $description = $request->input('description');
        $isPublic = $request->input('ispublic');
        $event = Event::find($id);

        if ($isPublic == 'private'){
            $isPublic = 0;
        }else{
            $isPublic = 1;
        }

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $image = $request->file('image');
                $imagePath = $image->store('images', 'public');

                $event->update([
                    'name' => $name,
                    'date' => $date,
                    'location' => $location,
                    'image_path' => $imagePath,
                    'type' => $type,
                    'description' => $description,
                    'ispublic' => $isPublic,
                ]);
            } else {
                return back()->withErrors([
                    'error' => 'Error uploading image. Please check the file format and try again!',
                ]);
            }
        }else {
            $event->update([
                'name' => $name,
                'date' => $date,
                'location' => $location,
                'type' => $type,
                'description' => $description,
                'ispublic' => $isPublic,
            ]);
        }

        $recent = Reading::getSelectedUsers($id);

        if ($isPublic == 0){
            $users = $request->input('users', []);

            foreach ($users as $user) {
                if (!in_array($user, $recent)) {
                    Reading::create([
                        'user' => $user,
                        'event' => $id,
                    ]);
                }
            }

            foreach ($recent as $rec) {
                if (!in_array($rec, $users)) {
                    Reading::where('user', $rec)->where('event', $id)->delete();
                }
            }
        }

        return redirect()->route('profile');
    }


    public function delete(Request $request){
        if (Auth::check()) {
            $request->validate([
                'event' => 'required',
            ]);

            $event = $request->input('event');

            Event::where('id', $event)->delete();

            return redirect()->route('profile');
        }else{
            return redirect()->route('login');
        }
    }

}
