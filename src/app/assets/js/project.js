window.addEventListener('load', function() {

    // auto remove alert after 7sec
    setTimeout(function () {
        if ($('.alert').is(':visible')){
            $('.alert').fadeOut();
        }
    }, 7000)

});