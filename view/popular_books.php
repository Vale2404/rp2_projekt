<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div class="tablice-side-by-side">

    <div class="tablica-blok">
        <h2>Najbolje ocijenjeni</h2>
        <table id="knjige-tablica">
            <tbody>
            <tr>
                <th></th>
                <th></th>
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
                        <?= number_format($book['prosjek'], 2) ?>/5.00
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="tablica-blok">
        <h2>Najčitaniji</h2>
        <table id="najcitanije">
            <tbody>
            <tr>
                <th></th>
                <th></th>
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
            </tbody>
        </table>
    </div>

</div>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
