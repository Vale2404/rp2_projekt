<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table id="knjige-tablica">
    <tbody>
    <tr>
        <th>Naslovnica</th>
        <th>Autor</th>
        <th>Naslov</th>
        <th></th>
    </tr>
    <?php foreach($lista_knjiga as $knjiga): ?>
        <tr class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($knjiga->id) ?>">
            <td>
                <img src="images/<?= htmlspecialchars($knjiga->slika_naslovnice) ?>" alt="Naslovnica" class="cover-img">
            </td>
            <td><?= htmlspecialchars($knjiga->autor) ?></td>
            <td><?= htmlspecialchars($knjiga->naziv) ?></td>
            <td>
                <?php if(!in_array($knjiga->id, $wishlist_ids) && !in_array($knjiga->id, $readlist_ids)): ?>
                    
                    <form method="post" action="index.php?rt=wishlist/add">
                        <input type="hidden" name="book_id_wishlist" value="<?= $knjiga->id ?>">
                        <button type="submit" class="add-wishlist-btn">Dodaj na listu želja</button>
                    </form><br>
                    <form method="post" action="index.php?rt=readlist/add">
                        <input type="hidden" name="book_id_readlist" value="<?= $knjiga->id ?>">
                        <button type="submit" class="add-readlist-btn">Dodaj na listu pročitanih</button>
                    </form>
                <?php elseif(in_array($knjiga->id, $wishlist_ids)): ?>
                    <span style="color: gray;">Već na listi želja</span>
                <?php elseif(in_array($knjiga->id, $readlist_ids)): ?>
                    <span style="color: gray;">Već na listi pročitanih</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>