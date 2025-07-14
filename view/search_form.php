<form class="form-search-wide" action="index.php?rt=search" method="post">
    <h4>Filtriraj i sortiraj naslove</h4>
    <div class="fsw-row">
        <input type="text" name="searchText" id="searchText"
               placeholder="🔍 Naziv djela / Ime autora" value="<?= htmlspecialchars($_SESSION['searchText'] ?? '') ?>">
        <select id="sortOption" name="sortOption">
            <option value="" disabled selected>Sortiraj rezultate pretrage po</option>
            <option value="Naziv" <?= ($_SESSION['sortOption'] ?? '') === "Naziv" ? 'selected' : '' ?>>Nazivu djela</option>
            <option value="Autor" <?= ($_SESSION['sortOption'] ?? '') === "Autor" ? 'selected' : '' ?>>Imenu autora</option>
            <option value="Godina" <?= ($_SESSION['sortOption'] ?? '') === "Godina" ? 'selected' : '' ?>>Godini izdanja</option>
            <option value="Prosjecna_ocjena" <?= ($_SESSION['sortOption'] ?? '') === "Prosjecna_ocjena" ? 'selected' : '' ?>>Prosječnoj ocjeni</option>
        </select>
    </div>
    <div class="checkboxes-row">
        <span class="checkbox-title">Filtriranje po žanrovima:</span>
            <?php foreach ($allGenres as $zanr): ?>
                <label>
                    <?= htmlspecialchars($zanr) ?>
                    <input type="checkbox" name="checkedGenres[]" value="<?= htmlspecialchars($zanr) ?>"
                        <?= !empty($_SESSION['checkedGenres']) && in_array($zanr, $_SESSION['checkedGenres']) ? 'checked' : '' ?>>
                </label>
            <?php endforeach; ?>
    </div>
    <div class="form-buttons">
        <button type="submit" formaction="index.php?rt=search/resetSearch">Poništi pretragu</button>
    </div>
</form>
