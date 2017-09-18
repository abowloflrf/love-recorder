@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">登陆</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group row justify-content-md-center {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-2 col-form-label text-left">邮箱</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" aria-describedby="emailHelpBlock" required autofocus>

                                @if ($errors->has('email'))
                                    <small id="emailHelpBlock" class="form-text text-danger">
                                        {{ $errors->first('email') }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row justify-content-md-center {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-2 col-form-label">密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" aria-describedby="passwordHelpBlock" required>

                                @if ($errors->has('password'))
                                    <span id="passwordHelpBlock" class="form-text text-danger">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-check row">
                            <div class="col-md-8 ml-md-auto">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">记住密码</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 ml-md-auto">
                                <button type="submit" class="btn btn-primary">
                                    登陆
                                </button>
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    忘记密码？
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
