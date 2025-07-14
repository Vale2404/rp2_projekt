<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
</head>
<body>
    <div id="add-book-msg"></div>
    <div class="login-wrapper">
        <h1>Knjigomat</h1>
        <h2>Prijava</h2>

        <form action="index.php" method="post" class="login-form">
            <label>Korisničko ime:</label><br>
            <input type="text" name="username"><br>
            <label>Lozinka:</label><br>
            <input type="password" name="password"><br><br>
            <input type="submit" name="login" value="Ulogiraj se" class="login">
        </form>
    </div>

    <div class="register-box">
        <span>Ako niste registrirani, registrirajte se ovdje:</span>
        <form action="index.php?rt=register" method="post">
            <button type="submit" class="cancel-btn">Registracija</button>
        </form>
    </div>

    <script>
    $(function(){
        <?php if(!empty($error)): ?>
            showAddBookMsg("<?= htmlspecialchars($error) ?>", "error");
        <?php endif; ?>
        <?php if(isset($_GET['registered']) && $_GET['registered'] == 1): ?>
            showAddBookMsg("Registracija uspješna! Možete se prijaviti.", "success");
        <?php endif; ?>

        function showAddBookMsg(msg, type) {
            $('#add-book-msg').removeClass('show success error').text('');
            $('#add-book-msg')
                .addClass(type + ' show')
                .text(msg);
            setTimeout(() => {
                $('#add-book-msg').removeClass('show');
            }, 2000);
        }
    });
    </script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
