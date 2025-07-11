$(function() {
    $('#knjige-tablica').on('click', '.book-row', function() {
        $('.book-row').removeClass('selected-row');
        $(this).addClass('selected-row');
        window.location = $(this).data('href');
    });
});

 $(document).ready(function() {
    $('#sortOption').select2({
        placeholder: 'Sortiraj rezultate po',
        allowClear: true,
        width: 'resolve', // automatska širina
        minimumResultsForSearch: Infinity
    });
});
