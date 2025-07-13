<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta developer="Maja Pavičić">
    <meta developer="Iva Poljak">
    <meta developer="Marko Validžić">
    <title>Knjigomat</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="js/index.js"></script>
    <script src="<?= __SITE_URL ?>/js/najpopularnije.js?v=1"></script>

</head>

<body>
    <header>
        <div class="header-row">
            <h1>Knjigomat</h1>
        <div class="user-info">
            <form action="index.php" method="post" style="display: inline;">
                <span class="user-greeting">Bok, <?= $_SESSION['username'] ?>!</span> <br>
                <input type="submit" value="Odjavite se" name="btn_logout" class="logout">
            </form>
        </div>
        </div>
        <ul class="navbar">
            <li><a href="index.php?rt=search">Pretraga knjiga</a></li>
            <li><a href="index.php?rt=popular">Najpopularnije knjige</a></li>
            <li><a href="index.php?rt=wishlist">Za pročitati</a></li>
            <li><a href="index.php?rt=readlist">Pročitano</a></li>
            <?php if(isset($_SESSION['jel_admin']) && $_SESSION['jel_admin'] == 1): ?>
                <li class="dropdown">
                    <a href="#">Administracija &#9662;</a>
                    <ul class="dropdown-content">
                        <li><a href="index.php?rt=admin/books">Knjige</a></li>
                        <li><a href="index.php?rt=admin/users">Korisnici</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </header>

    <main>
 <?php if (isset($naslov)): ?>
    <div class="header-row">
        <h1><?= htmlspecialchars($naslov) ?></h1>
    </div>
<?php endif; ?>
