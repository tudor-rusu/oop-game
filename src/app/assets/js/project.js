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
        let heroAttr    = $('#hero-attributes');
        let beastAttr   = $('#beast-attributes');
        let btnObj      = $('#fight');
        let initialText = btnObj.html();
        //set data
        let dataFight   = {
            round: 0,
            hero: {
                action: heroAttr.data('action'),
                health: heroAttr.find('tr[data-name="health"]').data('value'),
                strength: heroAttr.find('tr[data-name="strength"]').data('value'),
                defence: heroAttr.find('tr[data-name="defence"]').data('value'),
                speed: heroAttr.find('tr[data-name="speed"]').data('value'),
                luck: heroAttr.find('tr[data-name="luck"]').data('value')
            },
            beast: {
                action: beastAttr.data('action'),
                health: beastAttr.find('tr[data-name="health"]').data('value'),
                strength: beastAttr.find('tr[data-name="strength"]').data('value'),
                defence: beastAttr.find('tr[data-name="defence"]').data('value'),
                speed: beastAttr.find('tr[data-name="speed"]').data('value'),
                luck: beastAttr.find('tr[data-name="luck"]').data('value')
            }
        };

        btnObj.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');

        $.ajax({
            type: "POST",
            url: '/home/analise',
            data: dataFight,
            success: function (data) {
                btnObj.html(initialText).removeClass('disabled');
                if ($.isEmptyObject(data.error)) {
                    console.log(data);
                }
            }
        });
    });

});