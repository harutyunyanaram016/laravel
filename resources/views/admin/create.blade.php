@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 margin-top-50">
            <h2>Create User</h2>
            {{ Form::open(array('url' => 'admin/create','method'=>'POST')) }}

                    <label for="uname"><b>User Name</b></label>
                    <input class="form-control" type="text" placeholder="Enter Name" name="name">

                    <label for="uname"><b>User Email</b></label>
                    <input class="form-control" type="text" placeholder="Enter Email" name="email">


                    <label for="uname"><b>User Password</b></label>
                    <input class="form-control" type="text" placeholder="Enter Password" name="password">


                    <button  type="submit" class="btn-danger">Save</button>


            {{ Form::close() }}
        </div>
    </div>
@endsection