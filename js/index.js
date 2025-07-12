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

$(function() {
    var $form = $('.form-search-wide'); // Pošto koristiš klasu!

    // Select box auto-submit
    $('#sortOption').on('change', function() {
        $form.submit();
    });

    // Checkbox auto-submit
    $('input[name="checkedGenres[]"]').on('change', function() {
        $form.submit();
    });

    // Search input auto-submit (min 2 znaka, debounce)
    let debounce;
    $('#searchText').on('input', function() {
        clearTimeout(debounce);
        let val = $(this).val();
        debounce = setTimeout(function() {
            if (val.length >= 2 || val.length === 0)
                $form.submit();
        }, 1500); // 350ms debounce
    });
});
