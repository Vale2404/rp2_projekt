<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div style="display: flex; align-items: flex-start; gap: 30px; margin-bottom: 30px;">

    <!-- Slika knjige -->
    <div>
    <img src="<?= __SITE_URL ?>/images/<?= htmlspecialchars($knjiga->slika_naslovnice) ?>" alt="Naslovnica knjige" class="naslovnica">
    </div>

   <!-- Informacije o knjizi -->
    <table class="book-table">
        <tr>
            <td class="book-label">Autor</td>
            <td class="book-value"><?= htmlspecialchars($knjiga->autor) ?></td>
        </tr>
        <tr>
            <td class="book-label">Žanr</td>
            <td class="book-value"><?= htmlspecialchars($knjiga->zanr) ?></td>
        </tr>
        <tr>
            <td class="book-label">Godina</td>
            <td class="book-value"><?= htmlspecialchars($knjiga->godina) ?></td>
        </tr>
        <tr>
            <td class="book-label">Opis</td>
            <td class="book-value"><?= htmlspecialchars($knjiga->opis) ?></td>
        </tr>
        <tr>
            <td class="book-label">Prosječna ocjena</td>
            <td class="book-value"><?= htmlspecialchars($knjiga->prosjecna_ocjena) ?></td>
        </tr>
    </table>
    


</div>

<h3>Recenzije</h3>

<?php if ($moze_recenzirati): ?>
    <h3>Dodaj svoju recenziju</h3>
    <form action="index.php?rt=bookDetails/recenziraj" method="post">
        <input type="hidden" name="book_id" value="<?= htmlspecialchars($knjiga->id) ?>">

        <label for="ocjena">Ocjena (1–5):</label><br>
        <select name="ocjena" id="ocjena" required>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select><br><br>

        <label for="komentar">Komentar:</label><br>
        <textarea name="komentar" id="komentar" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Pošalji recenziju">
    </form>
    <?php else: ?>
        <p><em>Već ste recenzirali ovu knjigu ili niste prijavljeni.</em></p>
 <?php endif; ?>

<?php if (empty($recenzije)): ?>
    <p>Još nema recenzija za ovu knjigu.</p>
<?php else: ?>
    <ul class="recenzije">
        <?php foreach ($recenzije as $r): ?>
            <li>
                <strong>Korisnik <?= htmlspecialchars($r->username) ?></strong> 
                <br>
                Ocjena: <?= htmlspecialchars($r->ocjena) ?>/5<br>
                Komentar: <?= nl2br(htmlspecialchars($r->komentar)) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
