@extends('app')

@section('title', 'Dashboard')
@section('css', 'css/style.css')
@section('js', 'js/custom.js')

@section('content')

    @php
        use App\Models\JoiningModel;
    @endphp

    @if ($errors->any())
        <div class="alert alert-danger my-5">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="container">
        <div class="row justify-content-center">
            <div class="pt-5 pb-4 mt-5">
                <h1 class="text-center">Dashboard</h1>
            </div>
            <div class="btn-group">
                <a href="{{ route('add-event') }}" class="btn btn-outline-dark dashboard-btn">Create new Event</a>
                <button class="btn btn-outline-dark formbutton dashboard-btn" type="button" data-bs-toggle="collapse" data-bs-target="#formCollapse"
                        aria-expanded="false" aria-controls="formCollapse">Filter Events<i class="bi bi-caret-down-fill ms-1"></i>
                </button>
            </div>
        </div>
    </div>


    <div class="container mb-5 mt-4">
        <div class="collapse" id="formCollapse">
            <form id="filter-form" action="{{ route('filter') }}" method="GET" class="row g-3">
                @csrf
                <div class="form-group col-12 col-md-6">
                    <label class="formlabel" for="nameinput">Name/Description:</label>
                    <input type="text" class="form-control" id="nameinput" name="name">
                </div>
                <div class="form-group col-6 col-md-3">
                    <label class="formlabel" for="datefrominput">Date from:</label>
                    <input type="date" class="form-control" id="datefrominput" name="datefrom">
                </div>
                <div class="form-group col-6 col-md-3">
                    <label class="formlabel" for="datetoinput">Date to:</label>
                    <input type="date" class="form-control" id="datetoinput" name="dateto">
                </div>
                <div class="form-group col-12 col-md-6">
                    <label class="formlabel" for="locationinput">Location:</label>
                    <input type="text" class="form-control" id="locationinput" name="location">
                </div>
                <div class="form-group col-12 col-md-6">
                    <label class="formlabel" for="typeinput">Type of Event:</label>
                    <select class="form-select" id="typeinput" name="type" aria-label="Default select example">
                        <option value="Any">Select an event type</option>
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
                <div class="col-12 col-md-12">
                    <button type="submit" class="btn btn-outline-success formbutton">Filter<i class="bi bi-funnel ms-2"></i></button>
                </div>
            </form>
        </div>
    </div>


    <div class="container">
        <div class="row mx-1">
            @foreach ($events as $event)
                <div class="card mb-3 event-card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ route('event-image', ['eventId' => $event->id]) }}" class="card-img" alt="Event image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-title event-card-title">{{ $event->name }}</p>
                                <p class="card-text mt-3">{{$event->description }}</p>
                                <p class="card-text event-card-badges">
                                    <i class="bi bi-geo me-1"></i>{{$event->location }}
                                    <i class="bi bi-calendar2-event ms-2 me-1"></i></i>{{$event->date }}
                                    <i class="bi bi-caret-right-square ms-2 me-1"></i>{{$event->type }}
                                </p>
                            </div>
                            <div class="card-footer d-flex align-items-center align-bottom">
                                <button class="btn btn-outline-dark me-2 join-button"
                                        data-event="{{ $event->id }}"
                                        data-user="{{ $user_id }}"
                                        data-join-route="{{ route('join') }}">
                                    <i class="bi bi-suit-heart-fill me-2"></i>Join
                                </button>
                                <div class="joined-badge ms-auto">
                                    @if (Auth::check() && JoiningModel::isJoined($user_id, $event->id))
                                        <p>
                                            <i class="bi bi-patch-check-fill me-2"></i> Joined
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
