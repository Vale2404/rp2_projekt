<?php
require_once 'model/userservice.class.php';

class RegisterController {
    private $us;

    public function __construct($registry) {
        $this->userModel = new UserService($registry->db);
        $this->us = $this->userModel;
    }

    // GET: prikaz forme
    public function index() {
        require 'view/register_form.php';
    }

    // POST: obrada forme
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . __SITE_URL . '/index.php?rt=register');
            exit();
        }

        $ime = trim($_POST['ime']);
        $prezime = trim($_POST['prezime']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $email = trim($_POST['email']);

        if ($ime === '' || $prezime === '') {
            $_SESSION['register_error'] = 'Molimo unesite ime i prezime.';
            header('Location: ' . __SITE_URL . '/index.php?rt=register');
            exit();
        }

        if (!preg_match('/^[A-Za-z0-9.]{3,10}$/', $username)) {
            $_SESSION['register_error'] = 'Korisničko ime treba imati 3–10 znakova.';
            header('Location: ' . __SITE_URL . '/index.php?rt=register');
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = 'Neispravan e-mail.';
            header('Location: ' . __SITE_URL . '/index.php?rt=register');
            exit();
        }

        if ($this->us->userExists($username)) {
            $_SESSION['register_error'] = 'Korisnik s tim korisničkim imenom već postoji.';
            header('Location: ' . __SITE_URL . '/index.php?rt=register');
            exit();
        }

        $this->us->registerUser($ime, $prezime, $username, $password, $email);

        header('Location: ' . __SITE_URL . '/index.php?rt=login&registered=1');
        exit();
    }
}
?>
