@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    @if(!auth()->check())<b>guest</b>
                    @elseif(auth()->user()->member=='1')<b>lucky girl</b>
                    @else<b>lucky boy</b>
                    @endif
                </div>

            </div>
            @foreach($records as $record)
                @include('layouts.index-card-view')
            @endforeach


        </div>
    </div>
</div>
@include('layouts.detail-modal')
<script src="{{asset('js/detail-modal-loader.js')}}"></script>
@endsection



