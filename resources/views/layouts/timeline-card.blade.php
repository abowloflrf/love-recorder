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
        <img class="timeline-card-cover" src="{{$record->cover_img.'/timeline'}}">
        
        @if (!isset($_COOKIE['love-'.$record->id]))
            <i class="fa fa-heart love-btn love-btn-white" aria-hidden="true"></i>
        @elseif($_COOKIE['love-'.$record->id] == '1')
            <i class="fa fa-heart love-btn love-btn-red" aria-hidden="true"></i>
        @endif
        <span class="love-count love-count-0">{{$record->loves}}</span>
        
        <div class="cd-timeline-body">
            <h2>{{$record->title}}</h2>
            <p class="text-truncate">{{$record->body}}</p>
            <span class="cd-date">{{\Carbon\Carbon::parse($record->date_and_time)->diffForHumans() }}</span>
            <div class="text-right">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="loadDetailModal(this)">更多</a>
            </div>        
        </div>
    </div> <!-- cd-timeline-content -->
</div> <!-- cd-timeline-block -->