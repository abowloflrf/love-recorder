@extends('layouts.app')

@section('content')

<div class="container">
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
            @foreach($records as $record)
                @include('layouts.index-card-view')
            @endforeach


        </div>
    </div>
</div>
@include('layouts.detail-modal')
<script src="{{asset('js/detail-modal-loader.js')}}"></script>
@endsection



