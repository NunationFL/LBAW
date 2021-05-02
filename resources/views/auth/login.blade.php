@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Login</li>
    </ol>
</nav>

<div class="mt-lg-5 mt-3 container">
    <div class="bg-primary col-lg-6 col-md-8 col-12 mx-auto py-5 px-5 login_form">
        <div class="text-center mb-5 text-light pb-2">
            <h3>Login to <strong>Movie Club</strong></h3>
        </div>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group mb-3 mt-3 py-2">
                <label class="text-light" for="username">Username</label>
                <input type="text" name="username" class="form-control" placeholder="username" id="username">
            </div>
            <div class="form-group mb-3 mt-3 py-2">
                <label class="text-light" for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Your Password" id="password">
            </div>
            <input type="submit" value="Login" class="btn btn-block btn-secondary">
        </form>
    </div>
</div>
@endsection