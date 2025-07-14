<?php require_once __SITE_PATH . '/view/_header.php'; ?>
<div class="book-details-page" style="margin-left: 40px;">
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
            <td class="book-value">
            <?php if ($prosjek_ocjena == 0): ?>
                <em>Ova knjiga još nije ocijenjena.</em>
            <?php else: ?>
               <?= number_format($prosjek_ocjena, 2) ?>/5.00
                <?php
                    $punih = floor($prosjek_ocjena);
                    $decimalni = $prosjek_ocjena - $punih;

                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $punih) {
                            echo '★';
                        } elseif ($i == $punih + 1) {
                            if ($decimalni >= 0.75) {
                                echo '★';
                            } elseif ($decimalni >= 0.25) {
                                echo '⯨';
                            } else {
                                echo '☆'; 
                            }
                        } else {
                            echo '☆';
                        }
                    }
                    ?>
            <?php endif; ?>
        </td>
        </tr>
        <tr>
            <td class="book-label">Dodaj u listu</td>
            <td class="book-value">
                <?php if(!in_array($knjiga->id, $wishlist_ids) && !in_array($knjiga->id, $readlist_ids)): ?>
                    <form method="post" action="index.php?rt=wishlist/add" style="display: inline;">
                        <input type="hidden" name="book_id_wishlist" value="<?= $knjiga->id ?>">
                        <button type="submit" class="add-wishlist-btn">Lista želja</button>
                    </form>
                    <form method="post" action="index.php?rt=readlist/add" style="display: inline;">
                        <input type="hidden" name="book_id_readlist" value="<?= $knjiga->id ?>">
                        <button type="submit" class="add-readlist-btn">Pročitano</button>
                    </form>
                <?php elseif(in_array($knjiga->id, $wishlist_ids)): ?>
                    <span style="color: gray;">Već na listi želja</span>
                <?php elseif(in_array($knjiga->id, $readlist_ids)): ?>
                    <span style="color: gray;">Već na listi pročitanih</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    


</div>

<h2>Recenzije</h2>

<?php if ($moze_recenzirati): ?>
    <h3>Dodaj svoju recenziju</h3>
    <form action="<?= __SITE_URL ?>/index.php?rt=bookDetails/recenziraj" method="post">
        <input type="hidden" name="book_id" value="<?= htmlspecialchars($knjiga->id) ?>">

        <label>Ocjena:</label><br>
        <div class="star-rating">
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <input type="radio" id="star<?= $i ?>" name="ocjena" value="<?= $i ?>" required>
                <label for="star<?= $i ?>" title="<?= $i ?> zvjezdica">&#9733;</label>
            <?php endfor; ?>
        </div><br>


        <label for="komentar">Komentar:</label><br>
        <textarea name="komentar" id="komentar" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" class ="posalji_recenziju" value="Pošalji recenziju">
    </form>
    <?php else: ?>
        <p><em>Već ste recenzirali ovu knjigu ili niste prijavljeni.</em></p>
 <?php endif; ?>

<?php if (empty($recenzije)): ?>
    <div class="no-recenzije">
        <em>Ova knjiga trenutno nema recenzija.</em>
    </div>

<?php else: ?>
    <ul class="recenzije">
        <?php foreach ($recenzije as $r): ?>
            <li>
                <strong>Korisnik <?= htmlspecialchars($r->username) ?></strong> 
                <br>
                <?php
                    $ocjena = (int)$r->ocjena;
                    echo "Ocjena: {$ocjena}/5<br>";

                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $ocjena ? '★' : '☆';
                    }
                    echo "<br>";
                ?>
                Komentar: <?= nl2br(htmlspecialchars($r->komentar)) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</div>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
