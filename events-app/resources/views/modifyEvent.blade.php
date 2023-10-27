@extends('app')

@section('title', 'Modify Event')
@section('css', 'css/style.css')
@section('js', 'js/custom.js')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger my-5">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-title text-center">Modify the Event</p>
                        <form id="event-form" method="POST" action="{{ route('update-event') }}" enctype="multipart/form-data" class="row">
                            @csrf
                            <div class="form-group col-12 col-md-6">
                                <input class="form-check-input" type="checkbox" name="ispublic" value="private" id="flexCheckDefault" {{ $event->ispublic ? '' : 'checked' }}>
                                <label class="form-check-label" for="flexCheckDefault">Private Event</label>
                            </div>
                            <div class="form-group col-12 col-md-8">
                                <label for="select2">Select how can see the Event:</label>
                                <select id="select2" class="js-example-basic-multiple" name="users[]" multiple="multiple" style="width: 100%" {{ $event->ispublic ? 'disabled' : '' }}>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ in_array($user->id, $selectedUsers) ? 'selected' : '' }} >{{ $user->name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-8">
                                <label class="formlabel" for="nameinput">Name:</label>
                                <input type="text" class="form-control" id="nameinput" name="name" value="{{ $event->name }}" required>
                            </div>
                            <div class="form-group col-12 col-md-5">
                                <label class="formlabel" for="locationinput">Location:</label>
                                <input type="text" class="form-control" id="locationinput" name="location" value="{{ $event->location }}" required>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label class="formlabel" for="typeinput">Type of Event:</label>
                                <select class="form-select" id="typeinput" name="type" aria-label="Default select example" required>
                                    <option selected>Select a event type</option>
                                    <option value="Competetive" {{ $event->type == 'Competetive' ? 'selected' : '' }}>Competetive</option>
                                    <option value="Music" {{ $event->type == 'Music' ? 'selected' : '' }}>Music</option>
                                    <option value="Education" {{ $event->type == 'Education' ? 'selected' : '' }}>Education</option>
                                    <option value="Workshop" {{ $event->type == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                    <option value="Entertainment" {{ $event->type == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                                    <option value="Family - Children" {{ $event->type == 'Family - Children' ? 'selected' : '' }}>Family - Children</option>
                                    <option value="Gastro" {{ $event->type == 'Gastro' ? 'selected' : '' }}>Gastro</option>
                                    <option value="Online" {{ $event->type == 'Online' ? 'selected' : '' }}>Online</option>
                                    <option value="Other" {{ $event->type == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="formlabel" for="dateinput">Date:</label>
                                <input type="date" class="form-control" id="dateinput" name="date" value="{{ $event->date }}" required>
                            </div>
                            <div class="form-group col-12 col-md-5">
                                <label class="formlabel" for="imageinput">Image:</label>
                                <input type="file" class="form-control" id="imageinput" name="image">
                                <div id="fileHelp" class="form-text">Max size: 4Mb, Max Dim: 4000x4000px</div>
                            </div>
                            <div class="form-group col-12 col-md-12">
                                <label class="formlabel" for="descriptioninput">Description:</label>
                                <textarea class="form-control" id="descriptioninput" name="description" rows="3" maxlength="400" required>{{ $event->description }}</textarea>
                            </div>
                            <input type="hidden" name="id" value="{{ $event->id }}">
                            <div class="form-group col-12 col-md-12 mt-3">
                                <button type="submit" class="btn btn-outline-success me-2">Modify Event</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
