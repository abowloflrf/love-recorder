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

                        <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
                            <a href="#modal-media-image" uk-toggle>
                                <div class="uk-card-media-left uk-cover-container">
                                    <img src="{{$record->cover_img.'?imageView2/1/w/600/h/400'}}" alt="" uk-cover id="upload-img">
                                    <canvas width="600" height="400"></canvas>
                                </div>
                                </a>
                                <div>
                                    <div class="uk-card-body">
                                        <div class="test-upload uk-placeholder uk-text-center">
                                            <span uk-icon="icon: cloud-upload"></span>
                                            <span class="uk-text-middle">Attach binaries by dropping them here or</span>
                                            <div uk-form-custom>
                                                <input type="file" name="file" accept="image/*" id="file">
                                                <span class="uk-link">selecting one</span>
                                            </div>
                                        </div> 
                                        <progress id="progressbar" class="uk-progress" value="0" max="100" hidden></progress>
                                        <p class="progress-text" hidden>Uploading......</p>
                                    </div>
                                </div>

                            <div id="modal-media-image" class="uk-flex-top" uk-modal style="padding:40px 40px;">
                                <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical" >
                                    <button class="uk-modal-close-outside" type="button" uk-close></button>
                                    <img id="upload-img-modal" src="{{$record->cover_img}}" alt="">
                                </div>
                            </div>
                            <script>
                            (function ($) {

                                var bar = $("#progressbar")[0];

                                UIkit.upload('.test-upload', {
                                    mime:'image/*',
                                    'msg-invalid-mime':'File type not support!',
                                    fail:function(msg){
                                        UIkit.notification(msg,{status:'danger'});
                                    },
                                    url: '/records/{{$record->id}}/edit/change-img',
                                    name:'file',
                                    params:{
                                        'id':{{$record->id}},
                                        '_token':'{{csrf_token()}}'
                                    },
                                    beforeSend: function() { console.log('beforeSend', arguments);},
                                    beforeAll: function() { 
                                        console.log('beforeAll', arguments); 
                                        if(arguments[1][0].size>=10485760){
                                            UIkit.notification("File too large!",{status:'danger'});
                                            throw new Error('Too large!');
                                        }
                                        if(arguments[1][0].type.substring(0,5)!='image'){
                                            UIkit.notification("File type not support!",{status:'danger'});
                                            throw new Error('File type not support!');
                                        }
                                    },
                                    load: function() { console.log('load', arguments); },
                                    error: function() { console.log('error', arguments); },
                                    complete: function() { console.log('complete', arguments); },

                                    loadStart: function (e) {
                                        console.log('loadStart', arguments);

                                        bar.removeAttribute('hidden');
                                        $('.progress-text').removeAttr('hidden');
                                        bar.max =  e.total;
                                        bar.value =  e.loaded;
                                    },

                                    progress: function (e) {
                                        console.log('progress', arguments);
                                        bar.max =  e.total;
                                        bar.value =  e.loaded;

                                    },

                                    loadEnd: function (e) {
                                        console.log('loadEnd', arguments);

                                        bar.max =  e.total;
                                        bar.value =  e.loaded;
                                    },

                                    completeAll: function (arguments) {
                                        console.log('completeAll', arguments);
                                        var responseJSON=JSON.parse(arguments.responseText);   
                                        var upload_img = responseJSON['key'];

                                        setTimeout(function () {
                                            bar.setAttribute('hidden', 'hidden');
                                            $('.progress-text').attr('hidden', 'hidden');
                                        }, 200);
                                        if(responseJSON['key']!=null)
                                        {
                                            UIkit.notification(arguments.statusText,{status:'success'});
                                            $('#upload-img').attr('src','http://oub090rig.bkt.clouddn.com/'+upload_img+"?imageView2/1/w/600/h/400/"+Math.random());
                                            $('#upload-img-modal').attr('src','http://oub090rig.bkt.clouddn.com/'+upload_img+'?'+Math.random());
                                            $('#cover-img').val('http://oub090rig.bkt.clouddn.com/'+upload_img);
                                        }
                                        else{
                                            UIkit.notification(responseJSON['error'],{status:'danger'});
                                            console.log(responseJSON['error']);
                                        }
                                        
                                    }
                                });

                            })(jQuery);
                            </script>
                        </div>
                        
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