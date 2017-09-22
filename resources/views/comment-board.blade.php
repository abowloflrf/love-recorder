@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto mt-5">
            @if($flash=session('message'))
                <div class="alert alert-success" role="alert">
                    {{$flash}}
                </div>
            @endif  
            <h1 class="display-4 mb-3">想说点什么吗？</h1>
            <form method="POST" action="/board">
                {{csrf_field()}}
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
        
            @if(Auth::guest())
            @elseif(auth()->user()->member<3)
                <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="replyLabel">回复评论</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="/board/reply" id="reply-form">
                                {{csrf_field()}}
                                <input type="text" name="reply_to_id" class="form-control" id="recipient-name" readonly hidden>
                                <div class="form-group">
                                    <label for="reply_body" class="form-control-label">回复内容：</label>
                                    <textarea name="reply_body" class="form-control" required></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('reply-form').submit();">回复</button>
                        </div>
                        </div>
                    </div>
                </div>
                <script>
                    $('#replyModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var recipient = button.data('commentid') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)
                    modal.find('.modal-title').text('回复给id为'+recipient+'的留言')
                    modal.find('.modal-body input#recipient-name').val(recipient)
                    })
                </script>
            @endif

        </div>
    </div>    
</div>
@endsection