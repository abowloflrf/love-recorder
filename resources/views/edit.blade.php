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
                    <button class="btn btn-danger" type="submit">Delete this record</button>
                </form>
                
            </div>
                <div class="card-body">
                    <form action="/records/{{$record->id}}" method="post">
                        {{method_field('PUT')}}
                        {{csrf_field()}}
                        <input type="hidden" name="record_id" value="{{$record->id}}">   
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input class="form-control" type="text" name="title" value="{{$record->title}}">
                        </div>
                        <div class="form-group">
                            <label for="body">Content</label>
                            <textarea name="body" class="form-control" cols="30" rows="10">{{$record->body}}</textarea>
                        </div>
                        

                        <script src="{{asset('js/jquery.ui.widget.js')}}"></script>
                        <script src="{{asset('js/jquery.fileupload.js')}}"></script>
                        <script src="{{asset('js/jquery.fileupload-process.js')}}"></script>
                        <script src="{{asset('js/jquery.fileupload-validate.js')}}"></script>
                        <div class="form-group">
                            <label class="custom-file">
                                <input type="file" id="file-upload" name="file" class="custom-file-input" accept="image/*" multiple>
                                <span class="custom-file-control"></span>
                            </label>
                            <div class="progress mt-3">
                                <div class="progress-bar" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <img src="{{$record->cover_img}}?imageView2/1/w/300/h/200/" alt="upload" class="img-thumbnail mt-3 d-block">
                        </div>

                        <script>
                        $(function () {
                        $('#file-upload').fileupload({
                            url:'/records/{{$record->id}}/edit/change-img',
                            type:'POST',
                            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                            maxFileSize: 10000000,
                            dataType: 'json',
                            formData:{
                                '_token':'{{csrf_token()}}'
                            },
                            done: function (e, data) {
                                console.log(data);
                            },
                            done: function (e, data) {
                                console.log(data);
                                if(data._response.textStatus=="success"){
                                    var upload_img=data._response.result.key;
                                    $('#upload-img-input').val('http://oub090rig.bkt.clouddn.com/'+upload_img);
                                    $('.img-thumbnail').attr('src','http://oub090rig.bkt.clouddn.com/'+upload_img+"?imageView2/1/w/300/h/200/"+Math.random());
                                }else{
                                    alert("Upload failed!");
                                }

                            },
                            progressall: function (e, data) {
                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                $('.progress-bar').css(
                                    'width',
                                    progress + '%'
                                );
                            },
                            processfail: function (e, data) {
                                alert(data.files[data.index].name + "\n" + data.files[data.index].error);
                            }
                        });
                        });
                        </script>

                        <div class="form-group">
                            <input name="date_and_time" class="datepicker-here form-control" data-timepicker="true" data-language='zh' data-position="top left" value="{{$record->date_and_time}}">
                        </div>
                        <input type="hidden" name="cover_img" id="cover_img" value="{{$record->cover_img}}">                        
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>

                        <div class="form-group">
                            @foreach($errors->all() as $err)
                            <div class="uk-alert-danger" uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                <p>{{$err}}</p>
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