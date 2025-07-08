<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table id="knjige-tablica">
    <tr>
        <th>Naslovnica</th>
        <th>Autor</th>
        <th>Naslov</th>
    </tr>
    <?php foreach($wishlist as $knjiga): ?>
        <tr>
            <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($knjiga->id) ?>">
                <img src="images/<?= htmlspecialchars($knjiga->slika_naslovnice) ?>" alt="Naslovnica" class="cover-img">
            </td>
            <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($knjiga->id) ?>"><?= htmlspecialchars($knjiga->autor) ?></td>
            <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($knjiga->id) ?>"><?= htmlspecialchars($knjiga->naziv) ?></td>
            <td>
                <form method="post" action="index.php?rt=wishlist/delete">
                    <input type="hidden" name="book_id_wishlist" value="<?= $knjiga->id ?>">
                    <button type="submit">Makni s liste želja</button>
                </form><br>
                <form method="post" action="index.php?rt=wishlist/move">
                    <input type="hidden" name="book_id_wishlist" value="<?= $knjiga->id ?>">
                    <button type="submit">Premjesti u listu pročitanih</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>