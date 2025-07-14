<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error = '';
if(!empty($_SESSION['register_error'])) {
    $error = $_SESSION['register_error'];
    unset($_SESSION['register_error']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registracija</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
</head>
<body>
    <div id="add-book-msg"></div>
    <div class="login-wrapper">
        <h1>Knjigomat</h1>
        <h2>Registracija </h2>
        <form method="post" action="<?= __SITE_URL ?>/index.php?rt=register/register" class="login-form">
            <label>Ime:</label>
            <input type="text" name="ime"><br>
            <label>Prezime:</label>
            <input type="text" name="prezime"><br>
            <label>Korisničko ime:</label>
            <input type="text" name="username"><br>
            <label>Lozinka:</label>
            <input type="password" name="password"><br>
            <label>E-mail:</label>
            <input type="text" name="email"><br>
            <button type="submit" class="register">Registriraj se</button>
            <button type="submit" name="go_back_to_login" class="cancel-btn">Vrati se na login</button>
        </form>
    </div>

    <script>
    $(function(){
        <?php if(!empty($error)): ?>
            showAddBookMsg("<?= htmlspecialchars($error) ?>", "error");
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