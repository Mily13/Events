@extends('app')

@section('title', 'Add Event')

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
                        <p class="card-title text-center add-event-card-title">Create a new Event</p>
                        <form id="event-form" method="POST" action="{{ route('insert-event') }}" enctype="multipart/form-data" class="row">
                            @csrf
                            <div class="form-group col-12 col-md-6">
                                <input class="form-check-input" type="checkbox" name="ispublic" value="private" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">Private Event</label>
                            </div>
                            <div class="form-group col-12 col-md-8">
                                <label for="select2">Select how can see the Event:</label>
                                <select id="select2" class="js-example-basic-multiple" name="users[]" multiple="multiple" style="width: 100%" disabled required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-8">
                                <label class="formlabel" for="nameinput">Name:</label>
                                <input type="text" class="form-control" id="nameinput" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group col-12 col-md-5">
                                <label class="formlabel" for="locationinput">Location:</label>
                                <input type="text" class="form-control" id="locationinput" name="location" value="{{ old('location') }}" required>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label class="formlabel" for="typeinput">Type of Event:</label>
                                <select class="form-select" id="typeinput" name="type" aria-label="Default select example" required>
                                    <option selected>Select a event type</option>
                                    <option value="Competetive">Competetive</option>
                                    <option value="Music">Music</option>
                                    <option value="Education">Education</option>
                                    <option value="Workshop">Workshop</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Family - Children">Family - Children</option>
                                    <option value="Gastro">Gastro</option>
                                    <option value="Online">Online</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="formlabel" for="dateinput">Date:</label>
                                <input type="date" class="form-control" id="dateinput" name="date" value="{{ old('date') }}" required>
                            </div>
                            <div class="form-group col-12 col-md-5">
                                <label class="formlabel" for="imageinput">Image:</label>
                                <input type="file" class="form-control" id="imageinput" name="image">
                                <div id="fileHelp" class="form-text">Max size: 4Mb, Max Dim: 4000x4000px</div>
                            </div>
                            <div class="form-group col-12 col-md-12">
                                <label class="formlabel" for="descriptioninput">Description:</label>
                                <textarea class="form-control" id="descriptioninput" name="description" rows="3" maxlength="400" required>{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group col-12 col-md-12 mt-3">
                                <button type="submit" class="btn btn-outline-success me-2">Create Event</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
