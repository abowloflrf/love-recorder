@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
    <script src="{{asset('js/datepicker.js')}}"></script>
    <script src="{{asset('js/i18n/datepicker.zh.js')}}"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="/records" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" type="text" name="title">
                            </div>
                            <div class="form-group">
                                <label for="body">Content</label>
                                <textarea name="body" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            @include('layouts.create.upload')
                            <div class="form-group">
                                <input name="date_and_time" class="datepicker-here form-control" data-timepicker="true" data-language='zh' data-position="top left">
                                <script>
                                    $('.datepicker-here').datepicker().data('datepicker').selectDate(new Date());
                                </script>
                            </div>
                            <input type="hidden" name="cover_img" id="upload-img-input">
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