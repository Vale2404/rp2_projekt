<?php
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registracija</title>
</head>
<body>
<h2>Registracija </h2>
<form method="post" action="">
    Ime: <input type="text" name="ime"><br><br>
    Prezime: <input type="text" name="prezime"><br><br>
    Korisničko ime: <input type="text" name="username"><br><br>
    Lozinka: <input type="password" name="password"><br><br>
    E-mail: <input type="text" name="email"><br><br>
    <button type="submit">Registriraj se</button>
</form>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
