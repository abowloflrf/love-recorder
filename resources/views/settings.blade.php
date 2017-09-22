@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    个人设置
                </div>
                <div class="card-body">
                    <form method="POST" action="/settings">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" value="{{$user->email}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">昵称</label>
                            <input type="text" class="form-control" value="{{$user->name}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="intro">简介</label>
                            <input type="text" class="form-control" name="intro" value="{{$user->intro}}">
                        </div>
                        {{--  头像input，隐藏  --}}
                        <input type="hidden" name="avatar" id="upload-avatar-input" value="{{$user->avatar}}" required>
                        {{--  上传头像  --}}
                        <script src="{{asset('js/cos-js-sdk-v4.js')}}"></script>
                        <div class="form-group">
                            
                            <label class="custom-file">
                                <input type="file" id="avatar-upload" name="file" class="custom-file-input" accept="image/*" multiple>
                                <span class="custom-file-control">修改头像</span>
                            </label>
                            <div class="progress mt-3">
                                <div class="progress-bar" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <img src="{{$user->avatar.'/avatar'}}" alt="upload" class="avatar-thumbnail mt-3 d-block" style="width:100px">
                        </div>
                        <script>
                        //TODO:头像上传限制大小
                                $(document).ready(function() {
                                    $('#avatar-upload').on('change', function(e) {
                                        //新建cos对象
                                        var cos = new CosCloud({
                                            appid: {{env('COS_APPID')}},// APPID 必填参数
                                            bucket: "{{env('COS_BUCKET')}}",//bucketName 必填参数
                                            region: 'sh',//地域信息 必填参数 华南地区填gz 华东填sh 华北填tj
                                            getAppSign: function (callback) {
                                                //获取多次签名 必填参数
                                                $.ajax({
                                                    url:'/reusableToken'
                                                }).done(function (data) {
                                                    callback(data.sign);
                                                });        
                                            },
                                            getAppSignOnce: function (callback) {
                                                //单次签名，必填参数，参考上面的注释即可
                                                $.ajax({
                                                    url:'/onceToken',
                                                    data:{path: "/user/avatar/{{$user->id}}/"+e.target.files[0].name}
                                                }).done(function(data){
                                                    callback(data.sign);
                                                });
                                            }
                                        }); 
                                        //开始上传文件
                                        var successCallBack = function (result) {
                                            var path=result.data.resource_path;
                                            var upload_avatar=path.substring(24);
                                            $('#upload-avatar-input').val('https://loverecorder-1251779005.picsh.myqcloud.com'+upload_avatar);
                                            $('.avatar-thumbnail').attr('src','https://loverecorder-1251779005.picsh.myqcloud.com'+upload_avatar+'/avatar');
                                        };

                                        var errorCallBack = function (result) {
                                            alert(result.message);
                                        };

                                        var progressCallBack = function(curr){
                                            var progress = parseInt(curr * 100, 10);
                                            $('.progress-bar').css(
                                                'width',
                                                progress + '%'
                                            );
                                        };
                                        var file = e.target.files[0];
                                        var uploadpath="/user/avatar/{{$user->id}}/"+e.target.files[0].name;
                                        cos.uploadFile(successCallBack, errorCallBack, progressCallBack, "{{env('COS_BUCKET')}}", uploadpath, file, 1);
                                        
                                    });
                                });
                            </script>

                        <button type="submit" class="btn btn-primary">保存设置</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection