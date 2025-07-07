<?php
require_once 'model/UserModel.php';

class LoginController {
    private $userModel;

    public function __construct($registry) {
        $this->userModel = new UserModel($registry->db);
    }

    public function index() {
        $this->login();
    }


    public function login() {
        if (!isset($_POST['login'])) {
            require 'view/login_form.php';
            return;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';



        // dozvoljavamo ulaz bez unesenih usernamea i passworda radi lakseg testiranja
        if ($username === '' && $password === '') {
            // stvori testnog korisnika ako ga nema u bazi
            if (!$this->userModel->userExists('test')) {
                $this->userModel->registerUser(
                    'Test', 'Korisnik', 'test', 'test', 'test@mail.com'
                );
            }

            $_SESSION['username'] = 'test';
            //$_SESSION['test_user'] = true;
            header('Location: index.php?rt=books');

            exit();

        }

        // samo jedno prazno polje nije dozvoljeno
        if ($username === '' || $password === '') {
            $error = 'Nedostaje korisničko ime ili lozinka.';
            require 'view/login_form.php';
            return;
        }


        $user = $this->userModel->getUserByUsername($username);

        if (!$user) {
            $error = 'Korisnik nije registriran.';
            require 'view/login_form.php';
            return;
        }

        if (!password_verify($password, $user->password_hash)) {
            $error = 'Neispravna lozinka.';
            require 'view/login_form.php';
            return;
        }

        $_SESSION['username'] = $username;
        header('Location: index.php?rt=books');

        exit();
    }
}
