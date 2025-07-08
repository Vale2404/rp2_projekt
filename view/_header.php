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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script src="js/index.js"></script>
</head>

<body>
    <header>
        <div class="header-row">
            <h1>Knjigomat</h1>
            <form action="index.php" method="post">
                <span class="user-greeting">Bok, Hardcoded User !</span> <br>
                <input type="submit" value="Odjavite se" name="btn_logout" class="logout">
            </form>
        </div>
        <ul class="navbar">
            <li><a href="index.php?rt=search">Pretraga knjiga</a></li>
            <li><a href="index.php?rt=wishlist">Za pročitati</a></li>
            <li><a href="index.php?rt=readlist">Pročitano</a></li>
        </ul>
    </header>

    <main>
 <?php if (isset($naslov)): ?>
    <div class="header-row">
        <h2><?= htmlspecialchars($naslov) ?></h2>
    </div>
<?php endif; ?>
