 <div class="card mb-3">
    <div class="card-header">
        <strong>{{$comment->display_name}}</strong>
        @if(Auth::guest())
        @elseif(auth()->user()->member<3)
            <small>{{$comment->email}}</small>
        @endif
         - <em><small class="text-muted">{{$comment->created_at}}</small></em>
        @if(Auth::guest())
        @elseif(auth()->user()->member<3&&$comment->is_replied==FALSE)
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#replyModal" data-commentid="{{$comment->id}}">回复</button>
        @endif
    </div>
    <div class="card-body">
        {{$comment->comment}}
        @if($comment->is_replied==TRUE)
        <hr style="margin-top:0.5rem;margin-bottom:0.5rem;">
        <div class="ml-5">
            <small><em>
            <b>{{\App\Reply::where('reply_to_id', '=', $comment->id)->firstOrFail()->user()->value('name')}}</b>回复到：
            {{\App\Reply::where('reply_to_id', '=', $comment->id)->firstOrFail()->reply_body}}
            </small></em>
        </div>
        @endif
    </div>
</div>
