$(function() {
    $('#knjige-tablica').on('click', '.book-row', function() {
        $('.book-row').removeClass('selected-row');
        $(this).addClass('selected-row');
        window.location = $(this).data('href');
    });
});
