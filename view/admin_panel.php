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
        </form>
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
                    <td><button class="delete-btn">Obriši!</button></td>
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
                $('#add-book-msg').text('Knjiga obrisana!').css('color', 'red');
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
                    $('#add-book-msg').text("Knjiga dodana! Možete je pronaći na popisu.").css("color", "green");
                    $('#add-book-form')[0].reset();
                    ucitajKnjige();
                },
                error: function(xhr){
                    if(xhr.status == 400)
                        $('#add-book-msg').text(xhr.responseText).css("color", "red");
                    else
                        $('#add-book-msg').text("Greška prilikom dodavanja!").css("color", "red");
                }
            });
        });
    });
    </script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>