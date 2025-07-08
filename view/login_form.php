<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Goodreads klon</h1>
    <h2>Prijava </h2>
    <?php if (isset($info)) echo '<p class="info">' . htmlspecialchars($info) . '</p>'; ?>

    <form action="index.php" method="post">
        <label>Korisničko ime:</label><br>
        <input type="text" name="username"><br>
        <label>Lozinka:</label><br>
        <input type="password" name="password"><br><br>
        <input type="submit" name="login" value="Ulogiraj se">
    </form>
    <p>Nemate račun? <a href="index.php?rt=register">Registrirajte se ovdje</a>.</p>


    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
