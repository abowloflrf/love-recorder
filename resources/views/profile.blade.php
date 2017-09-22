@extends('layouts.app')
@section('content')
{{--  TODO:样式需要美化  --}}
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card profile-card">
                <div class="card-header">
                    <h1 class="display-4">{{$user->name}}</h1>
                </div>
                <div class="card-body">
                    <img src="{{$user->avatar.'/avatar'}}" class="profile-avatar mt-3 d-block">
                    <hr>
                    <p>简介:</p>
                    <p>{{$user->intro}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection