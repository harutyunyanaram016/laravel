<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Work;
use App\UserWork;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {


        $tday = UserWork::where('user_id', 1)->where('status', 'pause')
            ->whereDate('date', '=', Carbon::today()->toDateString())->orderBy('id', 'desc')->first();
        if (!$tday) {
            $work_time = 0;
        } else {
            $work_time = $tday->time;

        }
        $time = time() + (4 * 3600);
        $date = date('Y-m-d');
        $last_status = UserWork::where('date', '>=', $date)->where('user_id', 1)->
        orderBy('date', 'desc')->first();
        $status = 'yes';
        if ($last_status) {
            if ($last_status->status == 'stop') {
                $status = 'no';
                $work_time = $last_status->time;
            }
        } else {
            $work = Work::first();

            $start_work = date('d-m-Y') . ' ' . $work->start;

            if ($time > strtotime($start_work)) {
                $status = 'yes';
            } else {
                $status = 'no';
            }


        }
        if ($last_status) {
            if ($last_status->status == 'start') {
                $work_time = ($time - strtotime($last_status->date)) + $last_status->time;
                $status = 'start';
            }
        }

        $week_num = date('w');
        $week_start = date('m-d-Y', strtotime('-' . $week_num . ' days'));
        $works = UserWork::where('date', '>=', $week_start)->where('status', 'stop')
            ->where('user_id', '1')->get();
        $ids = array(1,2,3);
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
        $works_week = array();
        if ($works){
            for ($i = 0; $i < count($works); $i++) {
                $hours = $works[$i]->time / 3600;

                $works_week[$dayofweek = date('w', strtotime($works[$i]->date))] = array(

                    'time' => floor($hours)
                );
            }
        }


        $time = array('h'=>date('H:i:s',$work_time),'s'=>$work_time ,'works'=>$works_week, 'most'=>$mos, 'status'=>$status);
        return view('user.index', compact('time'));
    }


    public function getLogin(){
        return view('login');
    }

    public function postTimer(Request $request){
        $login = $request->all();
        $user_work_stat = new UserWork();
        $user_work_stat->user_id = $login['user_id'];
        $user_work_stat->status = $login['status'];
        if(isset($login['time'])){
            $user_work_stat->time = $login['time'];
        }
        $result = $user_work_stat->save();
        echo json_encode($result);

    }

}