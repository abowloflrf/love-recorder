@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
    <script src="{{asset('js/datepicker.js')}}"></script>
    <script src="{{asset('js/i18n/datepicker.zh.js')}}"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
            <div class="card">  
            <div class="card-header">
                Editing a record...
                <form class="float-right" action="/records/{{$record->id}}" method="post" onsubmit="return confirm('确认要删除?');">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button class="btn btn-danger" type="submit">删除</button>
                </form>
                
            </div>
                <div class="card-body">
                    <form action="/records/{{$record->id}}" method="post">
                        {{method_field('PUT')}}
                        {{csrf_field()}}
                        <input type="hidden" name="record_id" value="{{$record->id}}">   
                        <div class="form-group">
                            <label for="title">标题 (30字)</label>
                            <input class="form-control" type="text" name="title" value="{{$record->title}}" maxlength="30" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="body">内容 (140字)</label>
                            <textarea name="body" class="form-control" cols="30" rows="10" maxlength="140" required>{{$record->body}}</textarea>
                        </div>
                        
                        <script src="{{asset('js/cos-js-sdk-v4.js')}}"></script>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file-upload" name="file" accept="image/*" multiple>
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                            <div class="progress mt-3">
                                <div class="progress-bar" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <img src="{{$record->cover_img.'/thumb'}}" alt="upload" class="img-thumbnail mt-3 d-block" style="width:200px">
                        </div>

                        <script>
                        $(document).ready(function() {
                            $('#file-upload').on('change', function(e) {
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
                                            data:{path: "/record/{{$record->id}}/"+e.target.files[0].name}
                                        }).done(function(data){
                                            callback(data.sign);
                                        });
                                    }
                                }); 
                                //开始上传文件
                                
                                var successCallBack = function (result) {
                                    var cos_url=result.data.source_url;
                                    //替换默认访问url中的http为https
                                    cos_url=cos_url.replace("http://","https://");
                                    //替换默认访问url中cos访问为腾讯云万象优图图像处理域名pic
                                    cos_url=cos_url.replace(".cos",".pic");
                                    $('#cover_img').val(cos_url);
                                    $('.img-thumbnail').attr('src',cos_url+'/thumb');
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
                                //直接根据当前id拼接path后执行上传操作
                                var file = e.target.files[0];
                                var filepath="/record/{{$record->id}}/"+file.name;
                                cos.uploadFile(successCallBack, errorCallBack, progressCallBack, "{{env('COS_BUCKET')}}", filepath, file, 1);
                                   
                            });
                        });
                        
                        </script>

                        <div class="form-group">
                            <input name="date_and_time" class="datepicker-here form-control" data-timepicker="true" data-language='zh' data-position="top left" value="{{$record->date_and_time}}" required>
                        </div>
                        <input type="hidden" name="cover_img" id="cover_img" value="{{$record->cover_img}}" required>
                        <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                @if($record->private)
                                    <input type="checkbox" name="private" class="custom-control-input" checked>
                                @else
                                    <input type="checkbox" name="private" class="custom-control-input">
                                @endif
                                    <span class="custom-control-label">私密记录</span>
                                </label>
                        </div>                    
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">发布</button>
                        </div>

                        <div class="form-group">
                            @foreach($errors->all() as $err)
                            <div class="alert alert-danger" role="alert">
                                {{$err}}
                            </div>
                            @endforeach
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection