<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Work;

class AdminController extends Controller
{
    public function index(){
        $users = User::all();
        return view('admin.index', compact('users'));
    }
    public function createUser(){

        return view('admin.create');
    }
    public function deletUser(Request $request){
        $input = $request->all();

        $user = User::destroy($input['id']);
        return $user;

    }
}
