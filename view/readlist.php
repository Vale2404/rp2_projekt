<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<span style="float:right; margin-bottom: 10px; margin-right:10%;">Ukupno pročitano knjiga: <?= count($readlist) ?> </span>
<table id="knjige-tablica">
    <tbody>
    <tr>
        <th></th>
        <th>Autor</th>
        <th>Naslov</th>
    </tr>
    <?php foreach($readlist as $knjiga): ?>
        <tr class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($knjiga->id) ?>">
            <td>
                <img src="images/<?= htmlspecialchars($knjiga->slika_naslovnice) ?>" alt="Naslovnica" class="cover-img">
            </td>
            <td><?= htmlspecialchars($knjiga->autor) ?></td>
            <td><?= htmlspecialchars($knjiga->naziv) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>