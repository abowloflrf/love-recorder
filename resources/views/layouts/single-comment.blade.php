 <div class="card mb-3">
    <div class="card-header">
        <strong>{{$comment->display_name}}</strong>
        @if(Auth::guest())
        @elseif(auth()->user()->member<3)
            <small>{{$comment->email}}</small>
        @endif
         - <em><small class="text-muted">{{$comment->created_at}}</small></em>
    </div>
    <div class="card-body">
        {{$comment->comment}}
    </div>
</div>