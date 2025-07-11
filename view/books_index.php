<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form class="form-search-wide" action="index.php?rt=search/searchAndFilter" method="post">
    <h4>Filtriraj i sortiraj naslove</h4>
    <div class="fsw-row">
        <input type="text" name="searchText" id="searchText"
               placeholder="🔍 Naziv djela / Ime autora">
        <select id="sortOption" name="sortOption">
            <option value="" disabled selected>Sortiraj rezultate pretrage po</option>
            <option value="Naziv">Nazivu djela</option>
            <option value="Autor">Imenu autora</option>
            <option value="Godina">Godini izdanja</option>
            <option value="Prosjecna_ocjena">Prosječnoj ocjeni</option>
        </select>
    </div>
    <div class="checkboxes-row">
        <span class="checkbox-title">Uključeni žanrovi:</span>
        <label><input type="checkbox" name="checkedGenres[]" value="Fantastika"> Fantastika</label>
        <label><input type="checkbox" name="checkedGenres[]" value="Filozofija"> Filozofija</label>
        <label><input type="checkbox" name="checkedGenres[]" value="Horor"> Horor</label>
        <label><input type="checkbox" name="checkedGenres[]" value="Klasik"> Klasik</label>
        <label><input type="checkbox" name="checkedGenres[]" value="Roman"> Roman</label>
        <label><input type="checkbox" name="checkedGenres[]" value="DrKnjige"> Ostalo</label>
    </div>
    <div class="form-buttons">
        <button type="submit">Pretraži</button>
        <button type="reset">Poništi pretragu</button>
    </div>
</form>


<!-- <form class="form-search" action="index.php?rt=search/searchAndFilter" method="post">

    <input type="text" name="searchText" id="searchText" placeholder="🔍 Naziv djela / Ime autora">
    <select id="sortOption" name="sortOption">
        <option value="" disabled selected>Sortiraj rezultate pretrage po</option>
        <option value="Naziv">Nazivu djela</option>
        <option value="Autor">Imenu autora</option>
        <option value="Godina">Godini izdanja</option>
        <option value="Prosjecna_ocjena">Prosječnoj ocjeni</option>
    </select>

    <div class="checkboxes">
        <span class="checkbox-title">Žanrovi uključeni u pretragu:</span>        <label>
            <input type="checkbox" name="checkedGenres[]" value="Fantastika"> Fantastika
        </label>
        <label>
            <input type="checkbox" name="checkedGenres[]" value="Filozofija"> Filozofija
        </label>
        <label>
            <input type="checkbox" name="checkedGenres[]" value="Horor"> Horor
        </label>
        <label>
            <input type="checkbox" name="checkedGenres[]" value="Klasik"> Klasik
        </label>
        <label>
            <input type="checkbox" name="checkedGenres[]" value="Roman"> Roman
        </label>
        <label>
            <input type="checkbox" name="checkedGenres[]" value="DrKnjige"> Ostalo
        </label>
    </div>

    <div class="form-buttons">
        <button type="submit">Pretraži</button>
        <button type="reset">Poništi pretragu</button>
    </div>
</form> -->
<br><br>

<div>
    <table id="knjige-tablica">
        <tr>
            <th>Naslovnica</th>
            <th>Autor</th>
            <th>Naslov</th>
        </tr>
        <?php foreach($lista_knjiga as $knjiga): ?>
            <tr >
                <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($knjiga->id) ?>">
                    <img src="images/<?= htmlspecialchars($knjiga->slika_naslovnice) ?>" alt="Naslovnica" class="cover-img">
                </td>
                <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($knjiga->id) ?>"><?= htmlspecialchars($knjiga->autor) ?></td>
                <td class="book-row" data-href="?rt=bookDetails&temp_book_id=<?= urlencode($knjiga->id) ?>"><?= htmlspecialchars($knjiga->naziv) ?></td>
                <td>
                    <?php if(!in_array($knjiga->id, $_SESSION["wishlistIDs"]) && !in_array($knjiga->id, $_SESSION["readlistIDs"])): ?>
                        
                        <form method="post" action="index.php?rt=wishlist/add">
                            <input type="hidden" name="book_id_wishlist" value="<?= $knjiga->id ?>">
                            <button type="submit">Dodaj na listu želja</button>
                        </form><br>
                        <form method="post" action="index.php?rt=readlist/add">
                            <input type="hidden" name="book_id_readlist" value="<?= $knjiga->id ?>">
                            <button type="submit">Dodaj na listu pročitanih</button>
                        </form>
                    <?php elseif(in_array($knjiga->id, $_SESSION["wishlistIDs"])): ?>
                        <span style="color: gray;">Već na listi želja</span>
                    <?php elseif(in_array($knjiga->id, $_SESSION["readlistIDs"])): ?>
                        <span style="color: gray;">Već na listi pročitanih</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>