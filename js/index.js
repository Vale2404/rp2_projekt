$(function() {
    $('#knjige-tablica').on('click', '.book-row', function(e) {
        // Ako je klik bio na gumb, input, link ili textarea, prekini!
        if ($(e.target).is('button, a, input, textarea')) return;

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
