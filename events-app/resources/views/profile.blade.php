@extends('app')

@section('title', 'SignUp')
@section('css', 'css/style.css')
@section('js', 'js/custom.js')

@section('content')

    <h1 class="text-center title my-5 pt-2">My events:</h1>
    <div class="mx-5 my-2">
        <div class="table-responsive">
            <table id="my-events-table" class="table table-striped table-hover table-bordered" border="1px">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Location</th>
                    <th scope="col">Date</th>
                    <th scope="col">Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Public</th>
                    <th scope="col">
                        <a href="{{ route('add-event') }}" class="btn btn-outline-success">New Event</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->name }}</td>
                        <td>{{ $event->location }}</td>
                        <td>{{ $event->date }}</td>
                        <td>{{ $event->type }}</td>
                        <td>{{ $event->description }}</td>
                        <td>
                            @if ($event->ispublic)
                                public
                            @else
                                private
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <form action="{{ route('modify-event-form') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="event" value="{{ $event->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-warning">Modify</button>
                                </form>
                                <form action="{{ route('delete-event') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="event" value="{{ $event->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <h1 class="text-center title my-4">Events I've Joined:</h1>
    <div class="mx-5 my-2">
        <div class="table-responsive">
            <table id="my-events-table" class="table table-striped table-hover table-bordered" border="1px">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Location</th>
                    <th scope="col">Date</th>
                    <th scope="col">Type</th>
                    <th scope="col">Description</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($joined_events as $joined_event)
                    <tr>
                        <td>{{ $joined_event->name }}</td>
                        <td>{{ $joined_event->location }}</td>
                        <td>{{ $joined_event->date }}</td>
                        <td>{{ $joined_event->type }}</td>
                        <td>{{ $joined_event->description }}</td>
                        <td>
                            <form action="{{ route('delete-join') }}" method="POST">
                                @csrf
                                <input type="hidden" name="event" value="{{ $joined_event->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete Join</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
