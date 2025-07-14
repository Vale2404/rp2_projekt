<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<main>

    <section>
        <h3 style="margin-left:5%">Popis korisnika</h3>
        <table id="users-table">
            <thead>
                <tr>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Korisničko ime</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table><br><br>
        <div id="users-msg"></div>
    </section>

</main>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>

<script>
    function ucitajKorisnike() {
        $.getJSON('index.php?rt=admin/getAllUsersInJSON', function(korisnici) {
            let rows = '';
            korisnici.forEach(korisnik => {
                let jelAdmin = parseInt(korisnik.jel_admin) === 1;
                let jelTrenutniKorisnik = korisnik.ID === <?php echo (int)$_SESSION['user_id']; ?>;
                rows += `<tr data-id="${korisnik.ID}">
                    <td>${korisnik.Ime}</td>
                    <td>${korisnik.Prezime}</td>
                    <td>${korisnik.Username}</td>
                    <td>${korisnik.Mail}</td>
                    <td>${korisnik.jel_admin == 1 ? 'Je' : 'Nije'}</td>
                    <td>
                        <button class="show-comments-btn">Prikaži komentare</button>
                        ${(jelAdmin && !jelTrenutniKorisnik) ? '' : '<button class="delete-btn">Obriši korisnika!</button>'}
                    </td>
                </tr>`;
            });
            $('#users-table tbody').html(rows);
        });
    }

    $(function() {
        ucitajKorisnike();

        $('#users-table').on('click', '.delete-btn', function(){
            let $row = $(this).closest('tr');
            let id = $(this).closest('tr').data('id');
            let username = $row.find('td').eq(2).text();
            if(!confirm(`Jeste li sigurni da želite obrisati korisnika "${username}"?`))
                return;
            $.post('index.php?rt=admin/deleteUser', {user_id: id}, function(){
                $('#users-msg').removeClass().addClass('success show').text("Korisnik uspješno obrisan.");
                setTimeout(() => { $('#users-msg').removeClass('show'); }, 2000);
                ucitajKorisnike();
            }).fail(function() {
                $('#users-msg').removeClass().addClass('error show').text("Greška prilikom brisanja korisnika.");
                setTimeout(() => { $('#users-msg').removeClass('show'); }, 2000);
            });
        });

        $('#users-table').on('click', '.show-comments-btn', function(){
            let $row = $(this).closest('tr');
            let $commentRow = $row.next('.komentar-row');
            let $gumb = $(this);
            $('#users-table tr.selected-user').removeClass('selected-user');

            if ($commentRow.length) {
                $commentRow.remove();
                $gumb.text('Prikaži komentare');
                $row.removeClass('selected-user');
                return;
            }

            let userId = $row.data('id');
            $.getJSON('index.php?rt=admin/getAllCommentsFromUserInJSON&user_id=' + userId, function(komentari){
                let komentariHtml = komentari.length
                ? `<table class="comments-table" style="width:90%; margin: 0 auto;">
                        <thead>
                            <tr>
                                <th>Knjiga</th>
                                <th>Komentar</th>
                                <th>Ocjena</th>
                                <th>Akcija</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${komentari.map(k => `
                                <tr>
                                    <td>${k.Naziv}</td>
                                    <td>${k.Komentar}</td>
                                    <td>${k.Ocjena}</td>
                                    <td class="akcija">
                                        <button class="delete-review-btn" data-user-id="${k.ID_Korisnika}" data-book-id="${k.ID_Knjige}">
                                            Obriši komentar
                                        </button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>`
                : '<i>Nema komentara.</i>';
                $row.after(`<tr class="komentar-row"><td colspan="6">${komentariHtml}</td></tr>`);
                $gumb.text('Sakrij komentare');
                $row.addClass('selected-user');
            });
        });

        $('#users-table').on('click', '.delete-review-btn', function() {
            let userId = $(this).data('user-id');
            let bookId = $(this).data('book-id');
            let $commentRow = $(this).closest('tr');
            if (!confirm('Jeste li sigurni da želite obrisati ovaj komentar?')) return;
            $.post('index.php?rt=admin/deleteReview', { user_id: userId, book_id: bookId }, function() {
                $('#users-msg').removeClass().addClass('success show').text("Obrisan komentar.");
                setTimeout(() => { $('#users-msg').removeClass('show'); }, 2000);
                $commentRow.remove();
            }).fail(function() {
                $('#users-msg').removeClass().addClass('error show').text("Greška prilikom brisanja komentara.");
                setTimeout(() => { $('#users-msg').removeClass('show'); }, 2000);
            });
        });
    });
</script>