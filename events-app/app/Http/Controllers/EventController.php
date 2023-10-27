<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\ReadingModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller{
    public function getEvents(){
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;

            $personalEventsArray = ReadingModel::getEventIDs($user_id);
        }else{
            $personalEventsArray = [];
            $user_id = 0;
        }

        $publicEventsArray = EventModel::getPublicEventIDs();
        $events = EventModel::getEvents($publicEventsArray, $personalEventsArray);

        return view('dashboard', compact('events', 'user_id'));
    }


    public function getEventsFiltered(Request $request){
        $request->validate([
            'name' => 'max:99',
            'location' => 'max:99',
            'type' => 'max:99',
        ]);

        $name = $request->input('name');
        $datefrom = $request->input('datefrom');
        $dateto = $request->input('dateto');
        $location = $request->input('location');
        $type = $request->input('type');

        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;

            $personalEventsArray = ReadingModel::getEventIDs($user_id);
        }else{
            $personalEventsArray = [];
            $user_id = 0;
        }

        $publicEventsArray = EventModel::getPublicEventIDs();
        $events = EventModel::getFilteredEvents($publicEventsArray, $personalEventsArray, $name, $datefrom, $dateto, $location, $type);

        return view('dashboard', compact('events', 'user_id'));
    }


    public function eventForm(){
        if (Auth::check()) {
            $users = UserModel::getAllOtherUser();
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

        $users = UserModel::getAllOtherUser();
        $event_id = $request->input('event');
        $event = EventModel::where('id', $event_id)->first();
        $selectedUsers = ReadingModel::getSelectedUsers($event_id);

        return view('modifyEvent', compact('event', 'users', 'selectedUsers'));
    }


    public function insert(Request $request){
        $request->validate([
            'name' => 'required|max:99',
            'date' => 'required',
            'location' => 'required|max:99',
            'type' => 'required|max:99',
            'description' => 'required|max:400',
            'image' => 'image|max:4096|dimensions:min_width=50,min_height=50,max_width=4000,max_height=4000'
        ]);

        $name =  $request->input('name');
        $date = $request->input('date');
        $location =  $request->input('location');
        $type =  $request->input('type');
        $description = $request->input('description');
        $ispublic = $request->input('ispublic');

        if ($ispublic == 'private'){
            $ispublic = 0;
        }else{
            $ispublic = 1;
        }

        if (Auth::check()) {
            $user = Auth::user();
            $creator = $user->id;
        }

        $imageData = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageData = file_get_contents($image);
        }

        EventModel::create([
            'name' => $name,
            'date' => $date,
            'location' => $location,
            'image' => $imageData,
            'type' => $type,
            'description' => $description,
            'creator' => $creator,
            'ispublic' => $ispublic,
        ]);

        $event_id = EventModel::getEventIdByAttributes($name, $location, $date, $description, $type);

        if ($ispublic == 0){
            $users = $request->input('users', []);
            foreach ($users as $user) {
                ReadingModel::create([
                    'user' => $user,
                    'event' => $event_id,
                ]);
            }
        }

        return redirect()->route('dashboard');
    }


    public function update(Request $request){
        $request->validate([
            'name' => 'required|max:99',
            'date' => 'required',
            'location' => 'required|max:99',
            'type' => 'required|max:99',
            'description' => 'required|max:400',
            'image' => 'image|max:4096|dimensions:min_width=50,min_height=50,max_width=4000,max_height=4000'
        ]);

        $id = $request->input('id');
        $name =  $request->input('name');
        $date = $request->input('date');
        $location =  $request->input('location');
        $type =  $request->input('type');
        $description = $request->input('description');
        $ispublic = $request->input('ispublic');
        $event = EventModel::find($id);

        if ($ispublic == 'private'){
            $ispublic = 0;
        }else{
            $ispublic = 1;
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageData = file_get_contents($image);

            $event->update([
                'name' => $name,
                'date' => $date,
                'location' => $location,
                'image' => $imageData,
                'type' => $type,
                'description' => $description,
                'ispublic' => $ispublic,
            ]);
        }else{
            $event->update([
                'name' => $name,
                'date' => $date,
                'location' => $location,
                'type' => $type,
                'description' => $description,
                'ispublic' => $ispublic,
            ]);
        }

        $recent = ReadingModel::getSelectedUsers($id);

        if ($ispublic == 0){
            $users = $request->input('users', []);

            foreach ($users as $user) {
                if (!in_array($user, $recent)) {
                    ReadingModel::create([
                        'user' => $user,
                        'event' => $id,
                    ]);
                }
            }

            foreach ($recent as $rec) {
                if (!in_array($rec, $users)) {
                    ReadingModel::where('user', $rec)->where('event', $id)->delete();
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

            EventModel::where('id', $event)->delete();

            return redirect()->route('profile');
        }else{
            return redirect()->route('login');
        }
    }

    public function getImage($eventId){
        $event = EventModel::find($eventId);

        if (!$event || !$event->image) {
            $defaultImagePath = public_path('default.jpg');
            $defaultImage = file_get_contents($defaultImagePath);

            return response($defaultImage)
                ->header('Content-Type', 'image/jpeg');
        }

        return response($event->image)
            ->header('Content-Type', 'image/jpeg');
    }
}
