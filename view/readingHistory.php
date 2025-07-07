<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table id="knjige-tablica">
    <tr>
        <th>Naslovnica</th>
        <th>Autor</th>
        <th>Naslov</th>
    </tr>
    <?php foreach($readingHistory as $knjiga): ?>
        <tr class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($knjiga->id) ?>">
            <td>
                <img src="images/<?= htmlspecialchars($knjiga->slika_naslovnice) ?>" alt="Naslovnica" class="cover-img">
            </td>
            <td><?= htmlspecialchars($knjiga->autor) ?></td>
            <td><?= htmlspecialchars($knjiga->naziv) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>