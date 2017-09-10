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
        $('#detail-modal-cover').attr('src',data.cover_img+'!view?'+Math.random());
        $('#edit-button').attr('href','/records/'+record_id+'/edit');
    })
}
$("#detail-modal").on('hidden.bs.modal', function (e) {
    $(this).removeData("bs.modal");
})