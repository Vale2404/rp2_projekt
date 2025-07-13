<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<h2>Najbolje ocijenjene</h2>
<table id="knjige-tablica">
    <tbody>
    <tr>
        <th></th>
        <th>Naslovnica</th>
        <th>Autor</th>
        <th>Naslov</th>
        <th>Prosječna ocjena</th>
    </tr>
    <?php
    $it = 0;
    foreach ($topRated as $book): 
        $it++;?>
        <tr  class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($book['ID']) ?>">
            <td>
                <span class="rank-badge"><?=$it?>.</span>
            </td>
            <td>
                <img src="images/<?= htmlspecialchars($book['Slika_naslovnice']) ?>" alt="Naslovnica" class="cover-img">
            </td>
            <td>
                <?= htmlspecialchars($book['Autor']) ?>
            </td>
            <td>
                <?= htmlspecialchars($book['Naziv']) ?>
            </td>
            <td>
                <?= number_format($book['prosjek'], 2) ?>/5
            </td>
        </tr>
    <?php endforeach; ?>
    <tbody>
</table>

<h2>Najčitanije</h2>
<table id="knjige-tablica">
    <tbody>
    <tr>
        <th></th>
        <th>Naslovnica</th>
        <th>Autor</th>
        <th>Naslov</th>
        <th>Broj čitanja</th>
    </tr>
    <?php
    $it = 0;
    foreach ($mostPopular as $book): 
        $it++;?>
        <tr class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($book['ID']) ?>">
            <td>
                <span class="rank-badge"><?=$it?>.</span>
            </td>
            <td>
                <img src="images/<?= htmlspecialchars($book['Slika_naslovnice']) ?>" alt="Naslovnica" class="cover-img">
            </td>
            <td>
                <?= htmlspecialchars($book['Autor']) ?>
            </td>
            <td>
                <?= htmlspecialchars($book['Naziv']) ?>
            </td>
            <td>
                <?= $book['broj_citanja'] ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tbody>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
