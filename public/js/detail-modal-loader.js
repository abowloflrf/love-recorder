function loadDetailModal(e) {
    var record_id =$(e).parent().parent().parent().attr('id').split('-',2)[1];
    $.ajax({
        method:'GET',
        url:'api/records/'+record_id
    }).done(function (data) {
        $('#detail-modal-title').text(data.title);
        $('#detail-modal-body').text(data.body);
        $('#detail-modal-author').text(data.user_name);
        $('#detail-modal-time').text(data.date_and_time);
        $('#detail-modal-cover').attr('src',data.cover_img+'?imageView2/2/q/75/ignore-error/1');
        $('#edit-button').attr('href','/records/'+record_id+'/edit');
    })
}