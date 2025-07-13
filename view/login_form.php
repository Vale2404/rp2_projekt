<?php /*require_once __SITE_PATH . '/view/_header.php'; */?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Knjigomat</h1>
    <h2>Prijava </h2>
   <?php if (isset($_GET['registered']) && $_GET['registered'] == 1): ?>
    <p style="color: green;">Registracija uspješna! Možete se prijaviti.</p>
    <?php endif; ?>


    <form action="index.php" method="post">
        <label>Korisničko ime:</label><br>
        <input type="text" name="username"><br>
        <label>Lozinka:</label><br>
        <input type="password" name="password"><br><br>
        <input type="submit" name="login" value="Ulogiraj se" class="login">
    </form>
    <br>
    <form action="index.php?rt=register" method="post">
        <button type="submit" class="cancel-btn">Registrirajte se ovdje</button>
    </form>



    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
