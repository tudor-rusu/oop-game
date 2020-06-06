window.addEventListener('load', function () {

    // auto remove alert after 7sec
    setTimeout(function () {
        if ($('.alert').is(':visible')) {
            $('.alert').fadeOut();
        }
    }, 7000)

    // security token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // analise fight
    $('#fight').click(function (e) {
        e.preventDefault();
        let btnObj      = $('#fight');
        let initialText = btnObj.html();

        btnObj.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');

        $.ajax({
            type: "POST",
            url: '/home/analise',
            data: {
                test: 'test'
            },
            success: function (data) {
                btnObj.html(initialText).removeClass('disabled');
                if ($.isEmptyObject(data.error)) {
                    console.log(data);
                }
            }
        });
    });

});