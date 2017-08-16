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
                    @else<b>lucky boy</b>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <section id="cd-timeline" class="cd-container">
        @foreach($records as $record)
            @include('layouts.timeline-card')
        @endforeach
    </section> <!-- cd-timeline -->
</div>
</body>

@include('layouts.detail-modal')
<script src="{{asset('js/detail-modal-loader.js')}}"></script>
@endsection



