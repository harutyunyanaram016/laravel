@extends('.layout')

@section('content')
    <script>
        var elapsed_seconds = {{$time['s']}};
        var status = '{{$time['status']}}'
    </script>
    <div class="container1">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-7">
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
                    <div class="col-lg-5">
                        <div class="row">

                            <div class="col-xs-12 border">
                                Monday @if(isset($time['works'][1]['time'])) {{$time['works'][1]['time']}} hours @endif
                            </div>
                            <div class="col-xs-12 border">
                                Tuesday @if(isset($time['works'][2]['time'])) {{$time['works'][2]['time']}} hours @endif
                            </div>
                            <div class="col-xs-12 border">
                                Wednesday @if(isset($time['works'][3]['time'])) {{$time['works'][3]['time']}} hours @endif
                            </div>
                            <div class="col-xs-12 border">
                                Thursday @if(isset($time['works'][4]['time'])) {{$time['works'][4]['time']}} hours @endif
                            </div>
                            <div class="col-xs-12 border">
                                Friday @if(isset($time['works'][5]['time'])) {{$time['works'][5]['time']}} hours @endif
                            </div>
                            <div class="col-xs-12 border">
                                Saturday @if(isset($time['works'][6]['time'])) {{$time['works'][6]['time']}} hours @endif
                            </div>


                        </div>
                    </div>


                </div>
            </div>
            <div class="col-lg-6">
                <div class="border">
                    <h3>Working in Blessed Solutions</h3>
                    <div class="time">
                        <div class="Timer">{{$time['h']}}</div>
                    </div>

                    <div class="work-buttons">
                        <button class="btn-primary" id="start" @if($time['status'] == 'no') disabled @endif>@if($time['status'] == 'start') Pause @else Start @endif</button>
                        <button class="btn-danger" id="stop" @if($time['s'] < 1 || $time['status'] == 'no') disabled  @endif>Stop</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 mosts">
                <h3 class="most-title">Leaders in this week</h3>
                <div class="most-body row">
                    @foreach($time['most'] as $key=>$most)
                    <div class="col-xs-12 border">
                        User {{$key}} {{floor($most/3600)}} hours
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



@endsection