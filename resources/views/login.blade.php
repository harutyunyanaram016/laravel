@extends('local')

@section('content')
    <h2>Login Form</h2>

    {{--<form action="/login" method="post">--}}
        {!! Form::open(['url' => '/login', 'method'=>'post']) !!}
        <div class="container">
            <label for="uname"><b>Email</b></label>
            <input type="text" placeholder="Enter Username" name="email" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button type="submit">Login</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">

            <span class="psw">Forgot <a href="/forgot-password">password?</a></span>
        </div>
    {!! Form::close() !!}
@endsection