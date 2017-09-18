$('.love-btn-white').on('click', function clicklove() {
    var e = this;
    var record_id = $(e).parent().attr('id').split('-', 2)[1];
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        url: 'records/' + record_id + '/love-up'
    }).done(function (data) {
        if (data.status == 1) {
            $(e).css("color", "rgba(251, 80, 59, 0.8)");
            var current_count = parseInt($(e).next().text());
            $(e).next().html(current_count + 1);            
            $(e).off("click");
            document.cookie = "love-"+record_id+"=1; expires=Tue, 19 Jan 2038 03:14:07 UTC";
        } else {
            //
        }
    })
})