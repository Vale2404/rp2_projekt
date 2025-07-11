<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<main>

    <section>
        <h3>Popis korisnika</h3>
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
        </table>
        <div id="users-msg"></div>
    </section>

</main>

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
            if(!confirm(`Jeste li sigurni da želite obrisati korisnika "${username}"? Ovo će obrisati i sve njegove recenzije.`))
                return;
            $.post('index.php?rt=admin/deleteUser', {user_id: id}, function(){
                $('#users-msg').removeClass().addClass('success show').text("Obrisan korisnik i sve njegove recenzije.");
                setTimeout(() => { $('#users-msg').removeClass('show'); }, 2000);
                ucitajKorisnike();
            }).fail(function() {
                $('#users-msg').removeClass().addClass('error show').text("Greška prilikom brisanja korisnika.");
                setTimeout(() => { $('#users-msg').removeClass('show'); }, 2000);
            });
        });
    });
</script>