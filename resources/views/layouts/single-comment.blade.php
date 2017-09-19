 <div class="card">
    <div class="card-header"><strong>{{$comment->display_name}}</strong> - <em><small class="text-muted">{{$comment->created_at}}</small></em></div>
    <div class="card-body">
        {{$comment->comment}}
    </div>
</div>