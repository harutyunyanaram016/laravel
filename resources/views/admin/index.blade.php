@extends('admin.layout')

@section('content')
 <div class="row">
     <div class="col-xs-12">
         <h3 class="title-page">Working day in Blessed Solutions</h3>
          <div class="row">
              <div class="col-lg-4">
                  <!-- Calendar -->
                  <div class="hello-week">
                      <div class="hello-week__header">
                          <button class="btn demo-prev">◀</button>
                          <div class="hello-week__label"></div>
                          <button class="btn demo-next">▶</button>
                      </div>
                      <div class="hello-week__week"></div>
                      <div class="hello-week__month"></div>
                  </div>
              </div>
              <div class="col-lg-8">
                <div class="add-project">
                    <div class="row add-project-form">
                        <div class="col-lg-4">
                            <h4>Project Name</h4>
                            <input type="text" class="form-control" name="name" id="project-name">
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h4>Start</h4>
                                    <input type="text" class="form-control" name="start_date" id="project-start">
                                </div>
                                <div class="col-lg-5">
                                    <h4>End</h4>
                                    <input type="text" format="yyyy-mm-dd" class="form-control" name="end_date" id="project-end">
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn-primary" id="add-project">Add</button>
                                </div>
                            </div>
                            <script>
                                $(function () {
                                    $("#project-start").datetimepicker({
                                        format:'YYYY-MM-DD HH:mm:ss',
                                    });
                                    $("#project-end").datetimepicker({
                                        format:'YYYY-MM-DD HH:mm:ss',
                                    });


                                })
                            </script>
                        </div>
                    </div>
                    <div class="all-projects">
                        <table class="table">

                            <tbody>
                            @foreach($content['projects'] as $project)
                                <tr  @if(time() < strtotime($project->end_date)) data-id="{{$project->id}}" @endif>
                                    <td>{{$project->id}}</td>
                                    <td @if(time() < strtotime($project->end_date)) contenteditable @endif >{{$project->name}}</tdcontenteditable>
                                    <td @if(time() < strtotime($project->end_date)) contenteditable @endif >{{$project->start_date}}</td>
                                    <td @if(time() < strtotime($project->end_date)) contenteditable @endif >{{$project->end_date}}</td>


                                    <td>
                                        @if(time() < strtotime($project->end_date))
                                        <a href="javascript:void(0)" class="remove-project"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" class="edit-project">Edit</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

              </div>

          </div>
     </div>

     <div class="col-xs-12">
         <div class="project-users">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1">
                        <div class="row">
                            <div class="col-lg-7">
                                    @foreach($content['projects'] as $project)
                                        <div class="row border" data-id="{{$project->id}}"
                                             @foreach($content['user_project'] as $us_pj)
                                             @if($project->id == $us_pj->project_id) data-us="{{$us_pj->id}}"  @endif @endforeach >
                                            <div class="col-lg-12 border">
                                                @foreach($content['user_project'] as $us_pj)
                                                    @if($project->id == $us_pj->project_id)
                                                    <div class="col-lg-12">
                                                        @foreach($content['users'] as $user)
                                                            @if($user->id == $us_pj->user_id)
                                                                {{$user->name}}
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="col-lg-8 border">
                                                {{$project->name}} @if(time() > strtotime($project->end_date))<span class="red">Done</span>  @endif
                                            </div>
                                            <div class="col-lg-4">
                                                <select @if(time() > strtotime($project->end_date)) disabled @endif class="user-project form-control">
                                                    @foreach($content['users'] as $user)
                                                        <option
                                                                @foreach($content['user_project'] as $us_pj)
                                                                @if($project->id == $us_pj->project_id)
                                                                    @if($us_pj->user_id == $user->id)
                                                                        selected
                                                                    @endif
                                                                @endif
                                                                @endforeach

                                                                value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                            <div class="col-lg-5 users-work">
                                @foreach($content['user_work'] as $user_work)
                                    <div class="user-work-cont border">
                                        <p class="user-name">
                                            @foreach($content['users'] as $user)
                                                @if($user->id == $user_work['id'])
                                                    {{$user->name}}
                                                @endif
                                            @endforeach
                                        </p>
                                        <div class="time" data-id="{{$user_work['id']}}" data-status="{{$user_work['status']}}">
                                            <div class="Timer">{{date('H:i:s',$user_work['work'])}}</div>
                                            <div class="status">Work is {{$user_work['status']}}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
         </div>
     </div>
 </div>
 <div class="row">
     <div class="col-xs-12 mosts">
         <h3 class="most-title">Leaders in this week</h3>
         <div class="most-body row">
             @foreach($content['most'] as $key=>$most)
                 <div class="col-xs-12 border">
                     User {{$key}} {{floor($most/3600)}} hours
                 </div>
             @endforeach
         </div>
     </div>
 </div>

@endsection