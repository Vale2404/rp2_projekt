<?php

class AdminController extends BaseController {
    // Prikaz admin panela
    public function index()
    {
        $this->provjeraAdmina();
        $this->registry->template->naslov = 'Administracija knjiga';
        $this->registry->template->show('admin_books');
    }

    public function books()
    {
        $this->provjeraAdmina();
        $this->registry->template->naslov = 'Administracija knjiga';
        $this->registry->template->show('admin_books');
    }

    public function users()
    {
        $this->provjeraAdmina();
        $this->registry->template->naslov = 'Administracija korisnika i recenzija';
        $this->registry->template->show('admin_users_and_reviews');
    }

    public function addBook() {
        $this->provjeraAdmina();
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Autor = htmlentities(trim($_POST['Autor']), ENT_QUOTES, 'UTF-8');
            $Naziv = htmlentities(trim($_POST['Naziv']), ENT_QUOTES, 'UTF-8');
            $Zanr = htmlentities(trim($_POST['Zanr']), ENT_QUOTES, 'UTF-8');
            $Slika_naslovnice = htmlentities(trim($_POST['slika_naslovnice']), ENT_QUOTES, 'UTF-8');
            if($Slika_naslovnice === '')
                $Slika_naslovnice = 'nemaslike.jpg';
            $Godina = $_POST['Godina'] !== '' ? intval($_POST['Godina']) : null;
            $Opis = htmlentities(trim($_POST['Opis']), ENT_QUOTES, 'UTF-8');

            if($Autor === "" || $Naziv === "")
                $this->greska("Autor i naziv su obavezni!");

            if(strlen($Autor) > 30)
                $this->greska("Autor može imati najviše 30 znakova!");

            if(!preg_match('/^[A-Za-zČčĆćŽžŠšĐđ\s]{1,30}$/u', $Autor))
                $this->greska("Autor može sadržavati samo slova i razmak!");

            if(strlen($Naziv) > 30)
                $this->greska("Naziv može imati najviše 30 znakova!");
    
            if(!preg_match('/^[A-Za-z0-9ČčĆćŽžŠšĐđ\s\-\.\,\!\?]{1,30}$/u', $Naziv))
                $this->greska("Naziv može sadržavati slova, brojke i osnovne znakove!");

            if(strlen($Zanr) > 30)
                $this->greska("Žanr može imati najviše 30 znakova!");

            if(!preg_match('/^[A-Za-z0-9ČčĆćŽžŠšĐđ\s\-\.\,\!\?]{0,30}$/u', $Zanr)) 
                $this->greska("Žanr može sadržavati slova, brojke i osnovne znakove!!");

            if(!preg_match('/^[A-Za-z0-9_\-]{0,30}\.jpg$/i', $Slika_naslovnice))
                $this->greska("Naziv slike mora biti u formatu 'ime.jpg', bez putanja i razmaka!");

            if($Godina !== null && $Godina > intval(date('Y')))
                $this->greska("Godina nije ispravna!!");

            $ls = new LibraryService($this->registry->db);
            $ls->addBook($Autor, $Naziv, $Zanr, $Slika_naslovnice, $Godina, $Opis);

            http_response_code(200);
            exit();
        } else {
            http_response_code(405);
            echo "Neispravan zahtjev.";
            exit();
        }
    }

    public function deleteBook() {
        $this->provjeraAdmina();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['book_id']);
            $ls = new LibraryService($this->registry->db);
            $ls->deleteBook($id);
            http_response_code(200);
            exit();
        } else {
            http_response_code(405);
            echo "Neispravan zahtjev.";
            exit();
        }
    }

    public function getAllBooksInJSON() {
        $this->provjeraAdmina();
        header('Content-Type: application/json');
        $ls = new LibraryService($this->registry->db);
        echo json_encode($ls->getAllBooks());
        exit();
    }

    public function getAllUsersInJSON() {
        $this->provjeraAdmina();
        header('Content-Type: application/json');
        $us = new UserService($this->registry->db);
        echo json_encode($us->getAllUsers());
        exit();
    }

    public function getAllCommentsFromUserInJSON() {
        $this->provjeraAdmina();
        header('Content-Type: application/json');
        $user_id = (int)($_GET['user_id'] ?? 0);
        $ls = new LibraryService($this->registry->db);
        echo json_encode($ls->getAllCommentsFromUser($user_id));
        exit();
    }

    public function deleteUser() {
        $this->provjeraAdmina();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $us = new UserService($this->registry->db);
            $us->deleteUser($user_id);
            http_response_code(200);
            exit();
        } else {
            http_response_code(405);
            echo "Neispravan zahtjev.";
            exit();
        }
    }

    public function deleteReview() {
        $this->provjeraAdmina();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $book_id = $_POST['book_id'];
            $ls = new LibraryService($this->registry->db);
            $ls->deleteReview($user_id, $book_id);
            http_response_code(200);
            exit();
        } else {
            http_response_code(405);
            echo "Neispravan zahtjev.";
            exit();
        }
    }

    public function updateBook() {
        $this->provjeraAdmina();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $atribut = $_POST['atribut'];
            $vrijednost = $_POST['vrijednost'];

            switch($atribut) {
                case 'Autor':
                    $vrijednost = htmlentities(trim($vrijednost), ENT_QUOTES, 'UTF-8');
                    if(strlen($vrijednost) > 30 || !preg_match('/^[A-Za-zČčĆćŽžŠšĐđ\s]{1,30}$/u', $vrijednost))
                        $this->greska("Neispravan autor!");
                    break;
                case 'Naziv':
                    $vrijednost = htmlentities(trim($vrijednost), ENT_QUOTES, 'UTF-8');
                    if(strlen($vrijednost) > 30 || !preg_match('/^[A-Za-z0-9ČčĆćŽžŠšĐđ\s\-\.\,\!\?]{1,30}$/u', $vrijednost))
                        $this->greska("Neispravan naziv!");
                    break;
                case 'Zanr':
                    $vrijednost = htmlentities(trim($vrijednost), ENT_QUOTES, 'UTF-8');
                    if(strlen($vrijednost) > 30 || !preg_match('/^[A-Za-z0-9ČčĆćŽžŠšĐđ\s\-\.\,\!\?]{0,30}$/u', $vrijednost))
                        $this->greska("Neispravan žanr!");
                    break;
                case 'Slika_naslovnice':
                    $vrijednost = htmlentities(trim($vrijednost), ENT_QUOTES, 'UTF-8');
                    if(strlen($vrijednost) > 30 || !preg_match('/^[A-Za-z0-9_\-]{0,30}\.jpg$/i', $vrijednost))
                        $this->greska("Neispravna slika!");
                    break;
                case 'Godina':
                    $vrijednost = intval($vrijednost);
                    if($vrijednost > intval(date('Y')))
                        $this->greska("Neispravna godina!");
                    break;
                case 'Opis':
                    $vrijednost = htmlentities(trim($vrijednost), ENT_QUOTES, 'UTF-8');
                    break;
                default:
                    $this->greska("Neispravan atribut!");
            }
            $ls = new LibraryService($this->registry->db);
            $ls->updateBook($id, $atribut, $vrijednost);
            http_response_code(200);
            exit();
        } else {
            http_response_code(405);
            echo "Neispravan zahtjev.";
            exit();
        }
    }

    private function provjeraAdmina() {
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['jel_admin']) || $_SESSION['jel_admin'] != 1) {
            header('Location: index.php?rt=login');
            exit();
        }
    }

    private function greska($msg) {
        http_response_code(400);
        echo $msg;
        exit();
    }

    public function refreshAllBookAverages() {
        $this->provjeraAdmina();
        require_once __SITE_PATH . '/model/review.model.php';
        $rm = new ReviewModel($this->registry->db);
        $rm->osvjeziSveProsjecneOcjene();
        echo "Sve prosječne ocjene su osvježene.";
        exit();
    }

}

?>