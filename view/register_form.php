<?php /*require_once __SITE_PATH . '/view/_header.php'; */?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registracija</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<h1>Knjigomat</h1>
<h2>Registracija </h2>
<form method="post" action="<?= __SITE_URL ?>/index.php?rt=register/register">
    Ime: <input type="text" name="ime"><br>
    Prezime: <input type="text" name="prezime"><br>
    Korisničko ime: <input type="text" name="username"><br>
    Lozinka: <input type="password" name="password"><br>
    E-mail: <input type="text" name="email"><br>
    <button type="submit" class="register">Registriraj se</button>
    <br>
    <button type="submit" name="go_back_to_login" class="cancel-btn">Vrati se na login</button>
</form>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>