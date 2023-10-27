@extends('app')

@section('title', 'LogIn')
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
            <div class="col-12 col-md-8">
                <div class="card login-card mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('login.png') }}" class="card-img" alt="Login picture">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-title login-card-title">Login to your Account</p>
                                <form id="login-form" method="POST" action="{{ route('process-login') }}" class="row">
                                    @csrf
                                    <div class="form-group col-12 col-md-12">
                                        <label class="formlabel" for="emailinput">Email:</label>
                                        <input type="email" class="form-control" id="emailinput" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <label class="formlabel" for="passwordinput">Password:</label>
                                        <input type="password" class="form-control" id="passwordinput" name="password" required>
                                    </div>
                                    <div class="form-group col-12 col-md-12 mt-3">
                                        <button type="submit" class="btn btn-outline-success me-2">Login</button>
                                    </div>
                                    <div class="form-group col-12 col-md-12 mt-3">
                                        <p>Dont have an accunt? <a href="{{ route('signup') }}">Signup </a> now.</p>
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
