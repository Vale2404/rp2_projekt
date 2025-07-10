<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<main>

    <section>
        <h3>Dodaj novu knjigu</h3>
        <form id="add-book-form">
            <label>Autor: <input type="text" name="Autor" required></label><br>
            <label>Naziv: <input type="text" name="Naziv" required></label><br>
            <label>Žanr: <input type="text" name="Zanr"></label><br>
            <label>Slika naslovnice (URL ili putanja): <input type="text" name="slika_naslovnice"></label><br>
            <label>Godina: <input type="number" name="Godina" min="0"></label><br>
            <label>Opis: <textarea name="Opis"></textarea></label><br>
            <button type="submit">Dodaj knjigu</button>
        </form><br>
        <div id="add-book-msg"></div>
    </section><br>

    <section>
    <h3>Popis knjiga</h3>
    <table id="books-table">
        <thead>
            <tr>
                <th>Autor</th>
                <th>Naziv</th>
                <th>Žanr</th>
                <th>Slika naslovnice</th>
                <th>Godina</th>
                <th>Opis</th>
                <th>Prosječna ocjena</th>
                <th>Akcija</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </section><br>

    <script>
    function ucitajKnjige() {
        $.getJSON('index.php?rt=admin/getAllBooksInJSON', function(knjige) {
            let rows = '';
            knjige.forEach(knjiga => {
                rows += `<tr data-id="${knjiga.Id}">
                    <td>${knjiga.Autor}</td>
                    <td>${knjiga.Naziv}</td>
                    <td>${knjiga.Zanr}</td>
                    <td><img src="images/${knjiga.Slika_naslovnice}" alt="Naslovnica" class="cover-img"></td>
                    <td>${knjiga.Godina ? knjiga.Godina : ''}</td>
                    <td>${knjiga.Opis}</td>
                    <td>${knjiga.Prosjecna_ocjena}</td>
                    <td>
                        <button class="edit-btn">Uredi</button>
                        <button class="delete-btn">Obriši!</button>
                    </td>
                </tr>`;
            });
            $('#books-table tbody').html(rows);
        });
    }

    $(function() {
        ucitajKnjige();
        $('#books-table').on('click', '.delete-btn', function(){
            let $row = $(this).closest('tr');
            let autor = $row.find('td').eq(0).text();
            let naziv = $row.find('td').eq(1).text();
            if(!confirm(`Jeste li sigurni da želite obrisati knjigu "${naziv}" autora ${autor}?`))
                return;
            let id = $(this).closest('tr').data('id');
            $.post('index.php?rt=admin/deleteBook', {id: id}, function(){
                $('#add-book-msg').removeClass('show success error').text('');
                $('#add-book-msg')
                    .addClass('success show')
                    .text("Knjiga obrisana s popisa!");
                setTimeout(() => {
                    $('#add-book-msg').removeClass('show');
                }, 2000);

                ucitajKnjige();
            });
        });

        $('#add-book-form').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: 'index.php?rt=admin/addBook',
                type: 'POST',
                data: $(this).serialize(),
                success: function(resp){
                    $('#add-book-msg').removeClass('show success error').text('');
                    $('#add-book-msg')
                        .addClass('success show')
                        .text("Knjiga dodana! Možete je pronaći na popisu.");
                    setTimeout(() => {
                        $('#add-book-msg').removeClass('show');
                    }, 2000);

                    $('#add-book-form')[0].reset();
                    ucitajKnjige();
                },
                error: function(xhr){
                    $('#add-book-msg').removeClass('show success error').text('');

                    let msg = "Greška prilikom dodavanja!";
                    if(xhr.status == 400 && xhr.responseText) {
                        msg = xhr.responseText;
                    }
                    $('#add-book-msg')
                        .addClass('error show')
                        .text(msg);

                    setTimeout(() => {
                        $('#add-book-msg').removeClass('show');
                    }, 2500);
                }
            });
        });

        $('#books-table').on('click', '.edit-btn', function() {
            let $red = $(this).closest('tr');
            if($red.hasClass('editing')) return;
            $red.addClass('editing');

            let autor = $red.find('td').eq(0).text();
            let naziv = $red.find('td').eq(1).text();
            let zanr = $red.find('td').eq(2).text();
            let slika = $red.find('td').eq(3).find('img').attr('src').replace('images/', '');
            let godina = $red.find('td').eq(4).text();
            let opis = $red.find('td').eq(5).text();

            $red.find('td').eq(0).html(`<input type="text" value="${autor}">`);
            $red.find('td').eq(1).html(`<input type="text" value="${naziv}">`);
            $red.find('td').eq(2).html(`<input type="text" value="${zanr}">`);
            $red.find('td').eq(3).html(`<input type="text" value="${slika}">`);
            $red.find('td').eq(4).html(`<input type="number" min="0" value="${godina}">`);
            $red.find('td').eq(5).html(`<textarea>${opis}</textarea>`);
            $red.find('td').eq(7).html(
                `<button class="save-btn">Spremi</button>
                <button class="cancel-btn">Odustani</button>`
            );
        });

        $('#books-table').on('click', '.cancel-btn', function() {
            ucitajKnjige();
        });

        $('#books-table').on('click', '.save-btn', function() {
            let $red = $(this).closest('tr');
            let id = $red.data('id');

            let noviAutor = $red.find('td').eq(0).find('input').val();
            let noviNaziv = $red.find('td').eq(1).find('input').val();
            let noviZanr = $red.find('td').eq(2).find('input').val();
            let noviSlika = $red.find('td').eq(3).find('input').val();
            let novaGodina = $red.find('td').eq(4).find('input').val();
            let noviOpis = $red.find('td').eq(5).find('textarea').val();

            let podaci = [
                {atribut: 'Autor', vrijednost: noviAutor},
                {atribut: 'Naziv', vrijednost: noviNaziv},
                {atribut: 'Zanr', vrijednost: noviZanr},
                {atribut: 'Slika_naslovnice', vrijednost: noviSlika},
                {atribut: 'Godina', vrijednost: novaGodina},
                {atribut: 'Opis', vrijednost: noviOpis}
            ];

            let i = 0;
            function azurirajSljedeci() {
                if(i >= podaci.length) {
                    $('#add-book-msg')
                        .removeClass('show success error').text('')
                        .addClass('success show')
                        .text("Knjiga ažurirana!");
                    ucitajKnjige();
                    setTimeout(() => {
                        $('#add-book-msg').removeClass('show');
                        
                    }, 2000);
                    return;
                }
                $.post('index.php?rt=admin/updateBook', {
                    id: id,
                    atribut: podaci[i].atribut,
                    vrijednost: podaci[i].vrijednost
                })
                .done(function() {
                    i++;
                    azurirajSljedeci();
                })
                .fail(function(xhr) {
                    let msg = xhr.responseText || "Greška kod spremanja!";
                    $('#add-book-msg')
                        .removeClass('show success error').text('')
                        .addClass('error show')
                        .text(msg);
                    ucitajKnjige();
                    setTimeout(() => {
                        $('#add-book-msg').removeClass('show');
                    }, 2500);
                });
            }
            azurirajSljedeci();
        });
    });
    </script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>