function loadDetailModal(e) {
    var record_id =$(e).parent().parent().parent().attr('id').split('-',2)[1];
    $.ajax({
        method:'GET',
        url:'/record/'+record_id
    }).done(function (data) {
        $('#detail-modal-title').text(data.title);
        $('#detail-modal-body').text(data.body);
        $('#detail-modal-author').text(data.user_name);
        $('#detail-modal-time').text(data.created_at);
    })
}