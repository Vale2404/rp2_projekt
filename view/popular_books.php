<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<h2>Top 5 najbolje ocijenjenih knjiga</h2>
<table id="knjige-tablica">
    <tr>
        <th>Naslovnica</th>
        <th>Autor</th>
        <th>Naslov</th>
        <th>Prosječna ocjena</th>
    </tr>
    <?php foreach ($topRated as $book): ?>
        <tr>
            <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($book['ID']) ?>">
                <img src="images/<?= htmlspecialchars($book['Slika_naslovnice']) ?>" alt="Naslovnica" class="cover-img">
            </td>
            <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($book['ID']) ?>">
                <?= htmlspecialchars($book['Autor']) ?>
            </td>
            <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($book['ID']) ?>">
                <?= htmlspecialchars($book['Naziv']) ?>
            </td>
            <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($book['ID']) ?>">
                <?= number_format($book['prosjek'], 2) ?>/5
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Top 5 najpopularnijih knjiga</h2>
<table id="knjige-tablica">
    <tr>
        <th>Naslovnica</th>
        <th>Autor</th>
        <th>Naslov</th>
    </tr>
    <?php foreach ($mostPopular as $book): ?>
        <tr>
            <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($book['ID']) ?>">
                <img src="images/<?= htmlspecialchars($book['Slika_naslovnice']) ?>" alt="Naslovnica" class="cover-img">
            </td>
            <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($book['ID']) ?>">
                <?= htmlspecialchars($book['Autor']) ?>
            </td>
            <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($book['ID']) ?>">
                <?= htmlspecialchars($book['Naziv']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
