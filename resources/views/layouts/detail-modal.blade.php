<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title display-4" id="detail-modal-title">Loading...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-muted lead">Recorded by <span id="detail-modal-author">User</span> on <span class="font-italic"id="detail-modal-time">1 Jan 2017</span></p>            
        <img id="detail-modal-cover" src="" class="img-fluid">
        <div id="detail-modal-body" class="container p-5">
            Loading...
        </div>
      </div>
      <div class="modal-footer">
        @if(Auth::check()&&Auth::user()->member<3)
          <a href="" id="edit-button" class="btn btn-secondary">Edit</a>
        @endif
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>