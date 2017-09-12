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
                        Recording love...
                    </div>
                    <div class="card-body">
                        <form action="/records" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="title">Title (30)</label>
                                <input class="form-control" type="text" name="title" value="{{$faker->text($maxNbChars = 30)}}" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="body">Content (140)</label>
                                <textarea name="body" class="form-control" cols="30" rows="10" required>{{$faker->text($maxNbChars = 140)}}</textarea>
                            </div>
                            @include('layouts.create.upload')
                            <div class="form-group">
                                <input name="date_and_time" class="datepicker-here form-control" data-timepicker="true" data-language='zh' data-position="top left" required>
                                <script>
                                    $('.datepicker-here').datepicker().data('datepicker').selectDate(new Date());
                                </script>
                            </div>
                            <input type="hidden" name="cover_img" id="upload-img-input" required>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Submit</button>
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