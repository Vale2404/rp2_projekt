<?php
require_once 'model/userservice.class.php';

class RegisterController {
    private $us;

    public function __construct($registry) {
        $this->userModel = new UserModel($registry->db);
    }


    public function index() {
        $this->register();
    }


    public function register() {
        if (!isset($_POST['username'])) {
            require 'view/register_form.php';
            return;
        }

        $ime = trim($_POST['ime']);
        $prezime = trim($_POST['prezime']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $email = trim($_POST['email']);

        // Provjera da su polja ime i prezime unesena 
        if ($ime === '' || $prezime === '') {
            $error = 'Molimo unesite ime i prezime.';
            require 'view/register_form.php';
            return;
        }

        
        if (!preg_match('/^[A-Za-z0-9.]{3,10}$/', $username))  {
            $error = 'Korisničko ime treba imati 3–10 znakova.';
            require 'view/register_form.php';
            return;
        }

        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Neispravan e-mail.';
            require 'view/register_form.php';
            return;
        }

        // postoji li korisnik s istim usernameom vec
        if ($this->us->userExists($username)) {
            $error = 'Korisnik s tim korisničkim imenom već postoji.';
            require 'view/register_form.php';
            return;
        }

        // Spremi korisnika u bazu
        $this->us->registerUser($ime, $prezime, $username, $password, $email);

        header('Location: index.php?rt=login&registered=1');

        exit();
    }
}
?>
