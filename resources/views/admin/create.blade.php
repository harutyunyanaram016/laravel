@extends('admin.layout')

@section('content')
    <h2>Create User</h2>
    {{ Form::open(array('url' => 'admin/create','method'=>'POST')) }}
        <div class="container">
            <label for="uname"><b>User Name</b></label>
            <input type="text" placeholder="Enter Name" name="uname" required>
            <label for="uname"><b>User Email</b></label>
            <input type="text" placeholder="Enter Email" name="uemail" required>
            <label for="uname"><b>User Password</b></label>
            <input type="text" placeholder="Enter Password" name="upassword" required>

        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" class="cancelbtn">Cancel</button>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
    {{ Form::close() }}

@endsection