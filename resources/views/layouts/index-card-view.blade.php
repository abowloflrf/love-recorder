<div class="uk-badge uk-label">{{\Carbon\Carbon::parse($record->date_and_time)->diffForHumans() }}</div>
<div id="record-{{$record->id}}" class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
    <div class="uk-card-media-left uk-cover-container">
        <img src="{{asset('img/light.jpg')}}" alt="" uk-cover>
        <canvas width="600" height="400"></canvas>
    </div>
    <div>
        <div class="uk-card-body">
            <h3 class="uk-card-title">{{$record->title}}</h3>
            <p class="uk-text-truncate">{{$record->body}}</p>
        </div>
        <div class="uk-card-footer">
            <a href="#modal-overflow" class="uk-button uk-button-text" uk-toggle onclick="loadDetailModal(this)">Read more</a>
        </div>
    </div>
</div>
<hr>