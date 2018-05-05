<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;
use App\Work;
use App\UserWork;
use App\Project;
use App\UserProject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function index(){

        if(Cookie::get('user')){
            $user = User::where('id',Cookie::get('user'))->first();
        }else{
            return redirect('/login')->withCookie(Cookie::forget('user'));
        }

        if(!$user){
            return redirect('/login')->withCookie(Cookie::forget('user'));
        }
        if($user->role == 'user'){
            return redirect('/');
        }

        $projects = Project::all();
        $users = User::all();
        $user_work = array();
        foreach ($users as $user){
            $tday = UserWork::where('user_id', $user->id)
                ->whereDate('date', '=', Carbon::today()->toDateString())->orderBy('id', 'desc')->first();

            if(!$tday)
            {

                $user_work[] = array(
                    'id'=>$user->id,
                    'status' =>'stop',
                    'work'=>0
                );
            }
            else
                {
                if($tday->status == 'pause')
                {
                    $user_work[] = array(
                        'id'=>$user->id,
                        'status' =>'pause',
                        'work'=>$tday->time
                    );

                }
                elseif($tday->status == 'stop')
                {
                    $user_work[] = array(
                        'id'=>$user->id,
                        'status' =>'stop',
                        'work'=>$tday->time
                    );
                }
                else{
                    $time = time() + (4 * 3600);
                    $user_work[] = array(
                        'id'=>$user->id,
                        'status' =>'start',
                        'work'=>($time - strtotime($tday->date)) + $tday->time
                    );
                }
            }
        }

        $user_project = UserProject::all();
        $ids = array(1,2,3);
        $week_num = date('w');
        $week_start = date('m-d-Y', strtotime('-' . $week_num . ' days'));
        foreach ($ids as $id){
            $mosts[$id] = UserWork::where('date', '>=', $week_start)->where('status', 'stop')
                ->where('user_id',$id)
                ->sum('time');
        }
        arsort($mosts);
        $i = 0;
        foreach ($mosts as $key=>$most){
            if($i<3){
                ++$i;
                $mos[$key]=$most;
            }
        }
        $content = array('users'=>$users,'projects'=>$projects,'user_project'=>$user_project, 'most'=>$mos, 'user_work'=>$user_work);


        return view('admin.index', compact('content'));
    }

    public function getUsers(){
        if(Cookie::get('user')){
            $user = User::where('id',Cookie::get('user'))->first();
        }else{
            return redirect('/login')->withCookie(Cookie::forget('user'));
        }

        if(!$user){
            return redirect('/login')->withCookie(Cookie::forget('user'));
        }
        if($user->role == 'user'){
            return redirect('/');
        }
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function createUser(){

        return view('admin.create');
    }
    public function addUser(Request $request){
        if(!$this->isAdmin()){
            return redirect('/');
        }
        $input = $request->all();
        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        if($user->save()){
            return redirect('/admin/users');
        }else{
            return redirect('/admin/create-user');
        }


    }
    public function deletUser(Request $request){
        if(!$this->isAdmin()){
            return json_encode(false);
        }
        $input = $request->all();

        $user = User::destroy($input['id']);
        return $user;

    }
    public function addProject(Request $request){
        if(!$this->isAdmin()){
            return json_encode(false);
        }
        $input = $request->all();
        $project = new Project();
        $project->name = $input['name'];
        $project->start_date = $input['start'];
        $project->end_date = $input['end'];

        if($project->save()){
            return json_encode(true);
        }else{
            return json_encode(false);
        }

    }

    public function projectUser(Request $request){
        if(!$this->isAdmin()){
            return json_encode(false);
        }
        $input = $request->all();
//        var_dump($input);die;
        if($input["usPj"] == 0){
            $projectUser = new UserProject();
            $projectUser->user_id = $input["user"];
            $projectUser->project_id = $input["project"];
            if($projectUser->save()){
                return json_encode(true);
            }else{
                return json_encode(false);
            }
        }
        $projectUser = UserProject::find($input["usPj"]);
        $projectUser->user_id = $input["user"];
        $projectUser->project_id = $input["project"];
        if($projectUser->save()){
            return json_encode(true);
        }else{
            return json_encode(false);
        }

    }

    public function removeProject(Request $request){
        if(!$this->isAdmin()){
            return json_encode(false);
        }
        $input = $request->all();
        $project = Project::find($input['id']);
        $us_pj = UserProject::where('project_id',$input['id'])->first();

        if($project->delete() && $us_pj->delete()){
            return json_encode(true);
        }else{
            return json_encode(false);
        }
    }

    public function editProject(Request $request){
        if(!$this->isAdmin()){
            return json_encode(false);
        }
        $input = $request->all();
        $project = Project::find($input['id']);
        $project->name = $input['name'];
        $project->start_date = $input['start'];
        $project->end_date = $input['end'];

        if($project->save()){
            return json_encode(true);
        }else{
            return json_encode(false);
        }
    }
    public function isAdmin(){
        if(Cookie::get('user')){
            $user = User::where('id',Cookie::get('user'))->first();
        }else{
            return false;
        }

        if(!$user){
            return false;
        }
        if($user->role == 'user'){
            return false;
        }
        return true;
    }

}
