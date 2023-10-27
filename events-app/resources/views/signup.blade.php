@extends('app')

@section('title', 'SignUp')
@section('css', 'css/style.css')
@section('js', 'js/custom.js')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger mt-5">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container py-5 my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card signup-card mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('signup.png') }}" class="card-img img-fluid" alt="Picture">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-title signup-card-title">Create your new Account</p>
                                <form id="signup-form" method="POST" action="{{ route('process-signup') }}" class="row">
                                    @csrf
                                    <div class="form-group col-12 col-md-12">
                                        <label class="formlabel" for="nameinput">Name:</label>
                                        <input type="text" class="form-control" id="nameinput" name="name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <label class="formlabel" for="emailinput">Email:</label>
                                        <input type="email" class="form-control" id="emailinput" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <label class="formlabel" for="password">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <label class="formlabel" for="password_confirmation">Password confirmation:</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <label class="formlabel" for="phoneinput">Phone:</label>
                                        <input type="text" class="form-control" id="phoneinput" name="phone" value="{{ old('phone') }}" required>
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <label class="formlabel" for="birthdayinput">Birthday:</label>
                                        <input type="date" class="form-control" id="birthdayinput" name="birthday" value="{{ old('birthday') }}" required>
                                    </div>
                                    <div class="form-group col-12 col-md-12 mt-3">
                                        <button type="submit" class="btn btn-outline-success me-2">SignUp</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
