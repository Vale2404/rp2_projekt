<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<main>
    <?php if(empty($mojeRecenzije)): ?>
        <p class="recenzija">Nemate nijednu recenziju.</p>
    <?php else: ?>
        <table class="reviews-table" style="width:90%; margin: 0 auto;">
            <thead>
                <tr>
                    <th>Knjiga</th>
                    <th>Komentar</th>
                    <th>Ocjena</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($mojeRecenzije as $rec): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rec['Naziv']); ?></td>
                        <td><?php echo htmlspecialchars($rec['Komentar']); ?></td>
                        <td><?php echo htmlspecialchars($rec['Ocjena']); ?></td>
                        <td>
                            <form method="post" action="index.php?rt=myreviews/deleteReview" onsubmit="return confirm('Jeste li sigurni da želite obrisati ovu recenziju?');">
                                <input type="hidden" name="user_id" value="<?= (int)$rec['ID_Korisnika'] ?>">
                                <input type="hidden" name="book_id" value="<?= (int)$rec['ID_Knjige'] ?>">
                                <button type="submit" class="delete-btn">Obriši recenziju</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h3 style="margin-top:50px; text-align:center;">Pročitane knjige koje još niste recenzirali</h3>
    <?php if(empty($neocijenjeneKnjige)): ?>
        <p class="recenzija">Sve pročitane knjige ste već recenzirali!</p>
    <?php else: ?>
        <table class="reviews-table" style="width:90%; margin: 0 auto;">
            <thead>
                <tr>
                    <th>Knjiga</th>
                    <th>Autor</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($neocijenjeneKnjige as $knjiga): ?>
                    <tr>
                        <td><?= htmlspecialchars($knjiga['Naziv']); ?></td>
                        <td><?= htmlspecialchars($knjiga['Autor']); ?></td>
                        <td>
                            <form action="index.php" method="get">
                                <input type="hidden" name="rt" value="bookDetails">
                                <input type="hidden" name="temp_book_id" value="<?= (int)$knjiga['ID'] ?>">
                                <button type="submit" class="save-btn">Recenziraj</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>