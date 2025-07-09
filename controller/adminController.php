<?php

class AdminController extends BaseController {
    // Prikaz admin panela
    public function index()
    {
        $this->provjeraAdmina();

        $this->registry->template->naslov = 'Administracija';
        $this->registry->template->show('admin_panel');
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

            if($Autor === "" || $Naziv === "") {
                http_response_code(400);
                echo "Autor i naziv su obavezni!";
                exit();
            }

            if(strlen($Autor) > 30) {
                http_response_code(400);
                echo "Autor može imati najviše 30 znakova!";
                exit();
            }

            if(!preg_match('/^[A-Za-zČčĆćŽžŠšĐđ\s]{1,30}$/u', $Autor)) {
                http_response_code(400);
                echo "Autor može sadržavati samo slova i razmak!";
                exit();
            }

            if(strlen($Naziv) > 30) {
                http_response_code(400);
                echo "Naziv može imati najviše 30 znakova!";
                exit();
            }
            if(!preg_match('/^[A-Za-z0-9ČčĆćŽžŠšĐđ\s\-\.\,\!\?]{1,30}$/u', $Naziv)) {
                http_response_code(400);
                echo "Naziv može sadržavati slova, brojke i osnovne znakove!";
                exit();
            }

            if(strlen($Zanr) > 30) {
                http_response_code(400);
                echo "Žanr može imati najviše 30 znakova!";
                exit();
            }
            if(!preg_match('/^[A-Za-z0-9ČčĆćŽžŠšĐđ\s\-\.\,\!\?]{0,30}$/u', $Zanr)) {
                http_response_code(400);
                echo "Žanr može sadržavati slova, brojke i osnovne znakove!";
                exit();
            }

            if(!preg_match('/^[A-Za-z0-9_\-]{0,30}\.jpg$/i', $Slika_naslovnice)) {
                http_response_code(400);
                echo "Naziv slike mora biti u formatu 'ime.jpg', bez putanja i razmaka!";
                exit();
            }

            if($Godina !== null && $Godina > intval(date('Y'))) {
                http_response_code(400);
                echo "Godina nije ispravna!";
                exit();
            }

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
            $id = intval($_POST['id']);
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

    private function provjeraAdmina() {
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['jel_admin']) || $_SESSION['jel_admin'] != 1) {
            header('Location: index.php?rt=login');
            exit();
        }
    }
}

?>