$(function() {
    $('#najpopularnije').on('click', '.book-row', function(e) {
        console.log('Kliknuto!');
        if ($(e.target).is('button, a, input, textarea')) return;

        $(this).closest('tbody').find('.book-row').removeClass('selected-row');
        $(this).addClass('selected-row');

        const href = $(this).data('href');
        if (href) {
            console.log("Preusmjeravam na:", href);
            window.location.href = href;
        }
    });
});
