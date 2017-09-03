<div class="cd-timeline-block">
    <div class="cd-timeline-img cd-picture">
        <img src="{{asset('img/heart.svg')}}" alt="Picture">
    </div> <!-- cd-timeline-img -->

    <div class="cd-timeline-content" id="record-{{$record->id}}">
        <img src="{{$record->cover_img.'?imageView2/1/w/480/h/270/'.uniqid()}}" style="width:100%;border-radius:4px 4px 0 0;height:270px;background-color:#eee;">
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