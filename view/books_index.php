<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<?php require_once __SITE_PATH . '/view/search_form.php'; ?>
<br><br>

<div>
    <span style="float:right; margin-bottom: 10px; margin-right:10%;">Broj rezultata pretrage: <?= count($lista_knjiga) ?> </span>
    <table id="knjige-tablica">
        <tr>
            <th></th>
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
                    <?php if(!in_array($knjiga->id, $_SESSION["wishlistIDs"]) && !in_array($knjiga->id, $_SESSION["readlistIDs"])): ?>
                        
                        <form method="post" action="index.php?rt=wishlist/add">
                            <input type="hidden" name="book_id_wishlist" value="<?= $knjiga->id ?>">
                            <button type="submit" class="add-wishlist-btn">Dodaj na listu želja</button>
                        </form><br>
                        <form method="post" action="index.php?rt=readlist/add">
                            <input type="hidden" name="book_id_readlist" value="<?= $knjiga->id ?>">
                            <button type="submit" class="add-readlist-btn">Dodaj na listu pročitanih</button>
                        </form>
                        <?php elseif(in_array($knjiga->id, $_SESSION["wishlistIDs"])): ?>
                            <button type="button" disabled style="background: #eee; color: #888; border: 1px solid #ccc; cursor: not-allowed; padding: 7px 14px; border-radius: 8px;">
                                Već na listi želja
                            </button>
                        <?php elseif(in_array($knjiga->id, $_SESSION["readlistIDs"])): ?>
                            <button type="button" disabled style="background: #eee; color: #888; border: 1px solid #ccc; cursor: not-allowed; padding: 7px 14px; border-radius: 8px;">
                                Već na listi pročitanih
                            </button>
                        <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>