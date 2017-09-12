<div class="cd-timeline-block">
    @if($record->private==0)
        <div class="cd-timeline-img cd-green">
            <img src="{{asset('img/heart.svg')}}" alt="Heart">
        </div>
    @else
        <div class="cd-timeline-img cd-red">
            <img src="{{asset('img/lock.svg')}}" alt="Lock">
        </div>
    @endif

    <div class="cd-timeline-content" id="record-{{$record->id}}">
        <img src="{{$record->cover_img.'/timeline'}}" style="width:100%;border-radius:4px 4px 0 0;background-color:#eee;">
        <div class="cd-timeline-body">
            <h2>{{$record->title}}</h2>
            <p class="text-truncate">{{$record->body}}</p>
            <span class="cd-date">{{\Carbon\Carbon::parse($record->date_and_time)->diffForHumans() }}</span>
            <div class="text-right">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="loadDetailModal(this)">Read more</a>
            </div>
            
        </div>
    </div> <!-- cd-timeline-content -->
</div> <!-- cd-timeline-block -->