@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">注册</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group row justify-content-md-center{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 col-form-label">昵称</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" aria-describedby="nameHelpBlock" required autofocus>

                                @if ($errors->has('name'))
                                    <small id="nameHelpBlock" class="form-text text-danger">
                                        {{ $errors->first('name') }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row justify-content-md-center{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-2 col-form-label">电子邮件</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" aria-describedby="emailHelpBlock" required>

                                @if ($errors->has('email'))
                                    <small id="emailHelpBlock" class="form-text text-danger">
                                        {{ $errors->first('email') }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row justify-content-md-center{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-2 col-form-label">密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" aria-describedby="passwordHelpBlock" required>

                                @if ($errors->has('password'))
                                    <small id="passwordHelpBlock" class="form-text text-danger">
                                        {{ $errors->first('password') }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row justify-content-md-center">
                            <label for="password-confirm" class="col-md-2 col-form-label">确认密码</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row justify-content-md-center">
                            <label for="secret-code" class="col-md-2 col-form-label">神秘代码</label>

                            <div class="col-md-6">
                                <input id="secret-code" type="text" class="form-control" name="secret-code" aria-describedby="secret-codeHelpBlock">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 ml-md-auto">
                                <button type="submit" class="btn btn-primary">
                                    注册
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
