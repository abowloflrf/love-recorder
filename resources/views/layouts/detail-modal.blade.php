<div id="modal-overflow" uk-modal>
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h2 class="uk-modal-title" id="detail-modal-title">Loading...</h2>
            <p class="uk-article-meta">Written by <a href="#" id="detail-modal-author">User</a> on <span id="detail-modal-time">12 April 2012</span></p>
        </div>

        <div>
             <img src="" id="detail-modal-cover">
        </div>
        <script>
            var modalWidth=$('.uk-modal-dialog').width();
            $('#detail-modal-cover').css('width',modalWidth);
        </script> 
        
        <div class="uk-modal-body" uk-overflow-auto id="detail-modal-body">
            Loading...
        </div>

        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-danger uk-modal-close" type="button">Close</button>
        </div>

    </div>
</div>