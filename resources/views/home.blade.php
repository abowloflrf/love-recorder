@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/timeline.css')}}">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">Welcome</div>
                <div class="card-body">
                    @if(!auth()->check())<b>guest</b>
                    @elseif(auth()->user()->member=='1')<b>lucky girl</b>
                    @elseif(auth()->user()->member=='2')<b>lucky boy</b>
                    @else<b>{{auth()->user()->name}}</b>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="love-time mt-3">
        <h1 class="text-center">We have been together for:</h1>
        <h1 class="text-center"><span id="love-time-d"></span>Days <span id="love-time-h"></span>H <span id="love-time-m"></span>M <span id="love-time-s"></span>S</h1>
        <script>
            var lovedate=new Date(2017,0,1);
            var refreshTime=function(){
                var datenow = new Date();
                var duration=datenow-lovedate;
                var duration_d=parseInt(duration/(1000*60*60*24));
                var duration_h=parseInt((duration%(1000*60*60*24))/(3600*1000));
                var duration_m=parseInt((duration%(1000*60*60))/(60*1000));
                var duration_s=parseInt((duration%(1000*60))/(1000));
                
                document.getElementById('love-time-d').innerHTML=duration_d;
                document.getElementById('love-time-h').innerHTML=duration_h;
                document.getElementById('love-time-m').innerHTML=duration_m;
                document.getElementById('love-time-s').innerHTML=duration_s;
            }
            refreshTime();
            setInterval(refreshTime,1000);
            
        </script>
    </div>
    
    <section id="cd-timeline" class="cd-container">
        @if(!auth()->check()||auth()->user()->member==3)
            @foreach($records as $record)
                @if(!$record->private)
                    @include('layouts.timeline-card')
                @endif
            @endforeach
        @elseif(auth()->user()->member<3)
            @foreach($records as $record)
                @include('layouts.timeline-card')
            @endforeach
        @endif
    </section> <!-- cd-timeline -->
</div>
</body>

@include('layouts.detail-modal')
<script src="{{asset('js/detail-modal-loader.js')}}"></script>
<script src="{{asset('js/love.js')}}"></script>
@endsection



