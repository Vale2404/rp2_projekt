<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<h2>Top 5 najbolje ocjenjenih knjiga</h2>
<ul>
<?php foreach ($topRated as $book): ?>
    <li>
        <?= htmlspecialchars($book['Naziv']) ?> — 
        <?= number_format($book['prosjek'], 2) ?>/5

    </li>
<?php endforeach; ?>
</ul>

<h2>Top 5 najpopularnijih knjiga</h2>
<ul>
<?php foreach ($mostPopular as $book): ?>
    <li><?= htmlspecialchars($book['Naziv']) ?></li>
<?php endforeach; ?>
</ul>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
