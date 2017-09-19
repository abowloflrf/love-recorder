@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h4>想说点什么吗？</h4>
            <form method="POST" action="/board">
                {{ csrf_field() }}
                <div class="form-group form-row">
                    <div class="form-group col-sm-8">
                        <textarea class="form-control" name="comment" rows="9" required></textarea>
                    </div>                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">昵称</span>
                                <input type="text" name="display_name" class="form-control" placeholder="显示昵称" required>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <span class="input-group-addon">Email</span>
                            <input type="email" name="email" class="form-control" placeholder="仅我知道" required>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" style="padding:0;width:80px;"><img src="{{Captcha::src('flat')}}" alt="captcha" style="width:80px;height:30px;margin:0 4px" onclick="this.src='/captcha/flat?'+Math.random()"></img></span>
                                <input type="text" name="captcha" maxlength="4" class="form-control 
                                    @if ($errors->has('captcha'))
                                        is-invalid
                                    @endif" 
                                placeholder="验证码" required>
                            </div>
                        </div>
                        <div class="">
                            <button class="btn btn-outline-primary btn-block">发表留言</button>
                        </div> 
                    </div>
                </div>
            </form>

            <hr>

            @foreach($comments as $comment)
                @include('layouts.single-comment')
            @endforeach
            

        </div>
    </div>    
</div>
@endsection