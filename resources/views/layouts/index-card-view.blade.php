<div class="card w-50 mx-auto mb-5" id="record-{{$record->id}}">
    <img class="card-img-top" src="{{$record->cover_img.'?imageView2/1/w/480/h/270'}}" alt="Cover">
    <div class="card-body">
        <h4 class="card-title">{{$record->title}}</h4>
        <p class="card-text text-truncate">{{$record->body}}</p>
        <hr>
        <div class="text-right">
        <span class="badge badge-secondary">{{\Carbon\Carbon::parse($record->date_and_time)->diffForHumans() }}</span>
            <a href="#" class="btn btn-outline-primary btn-sm">View</a>
        </div>
    </div>
</div>