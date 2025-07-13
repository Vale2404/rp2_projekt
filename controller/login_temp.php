<?php
require_once 'model/userservice.class.php';

class LoginController {
    private $us;

    public function __construct($registry) {
        $this->us = new UserService($registry->db);
    }

    public function index() {
        $this->login();
    }


    public function login() {

        $info = null;
        if (isset($_GET['registered']) && $_GET['registered'] == 1) {
            $info = 'Registracija je bila uspješna. Možete se prijaviti.';
        }

        if (!isset($_POST['login'])) {
            if (isset($info)) $info = $info; 

            require 'view/login_form.php';
            return;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';



        // dozvoljavamo ulaz bez unesenih usernamea i passworda radi lakseg testiranja
        if ($username === '' && $password === '') {
            // stvori testnog korisnika ako ga nema u bazi
            if (!$this->us->userExists('test')) {
                $this->us->registerUser(
                    'Test', 'Korisnik', 'test', 'test', 'test@mail.com'
                );
            }

            $_SESSION['username'] = 'test';
            $_SESSION['user_id'] = 11;
            $_SESSION['jel_admin'] = 1;
            header('Location: index.php?rt=search');

            exit();

        }

        // samo jedno prazno polje nije dozvoljeno
        if ($username === '' || $password === '') {
            $error = 'Nedostaje korisničko ime ili lozinka.';
            if (isset($info)) $info = $info; 

            require 'view/login_form.php';
            return;
        }

        $user = $this->us->getUserByUsername($username);

        if (!$user) {
            $error = 'Korisnik nije registriran.';
            if (isset($info)) $info = $info;
            require 'view/login_form.php';
            return;
        }

        if (!password_verify($password, $user->password_hash)) {
            $error = 'Neispravna lozinka.';
            if (isset($info)) $info = $info;
            require 'view/login_form.php';
            return;
        }

        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['jel_admin'] = $user->jel_admin;
        header('Location: index.php?rt=search');

        exit();
    }
}
