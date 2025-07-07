<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table class="book-table">
    <tr>
        <td class="book-label">Autor</td>
        <td><?= htmlspecialchars($knjiga->autor) ?></td>
    </tr>
    <tr>
        <td class="book-label">Žanr</td>
        <td><?= htmlspecialchars($knjiga->zanr) ?></td>
    </tr>
    <tr>
        <td class="book-label">Godina</td>
        <td><?= htmlspecialchars($knjiga->godina) ?></td>
    </tr>
    <tr>
        <td class="book-label">Opis</td>
        <td><?= htmlspecialchars($knjiga->opis) ?></td>
    </tr>
    <tr>
        <td class="book-label">Prosječna ocjena</td>
        <td><?= htmlspecialchars($knjiga->prosjecna_ocjena) ?></td>
    </tr>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
