<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form action="index.php?rt=wishlist/downloadPdf" method="post">
    <button type="submit" class="download-pdf-btn" style="float: left; margin-bottom: 10px; margin-left:5%;">Preuzmi PDF popis knjiga za pročitati</button>
    <span style="float:right; margin-right:10%;">Ukupno knjiga za pročitati: <?= count($wishlist) ?> </span>
</form>

<table id="knjige-tablica">
    <tr>
        <th></th>
        <th>Autor</th>
        <th>Naslov</th>
        <th></th>
    </tr>
    <?php foreach($wishlist as $knjiga): ?>
        <tr class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($knjiga->id) ?>">
            <td>
                <img src="images/<?= htmlspecialchars($knjiga->slika_naslovnice) ?>" alt="Naslovnica" class="cover-img">
            </td>
            <td><?= htmlspecialchars($knjiga->autor) ?></td>
            <td><?= htmlspecialchars($knjiga->naziv) ?></td>
            <td>
                <form method="post" action="index.php?rt=wishlist/delete">
                    <input type="hidden" name="book_id_wishlist" value="<?= $knjiga->id ?>">
                    <button type="submit" class="remove-wishlist-btn">Makni s liste želja</button>
                </form><br>
                <form method="post" action="index.php?rt=wishlist/move">
                    <input type="hidden" name="book_id_wishlist" value="<?= $knjiga->id ?>">
                    <button type="submit" class="move-readlist-btn">Premjesti u listu pročitanih</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>