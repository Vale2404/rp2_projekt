<?php

class BookDetailsController extends BaseController {
    public function index() {

        $book_id = (int)($_GET["temp_book_id"] ?? 0);
        $ls = new LibraryService($this->registry->db);
        $tempKnjiga = $ls->getBook($book_id);
        

        $this->registry->template->knjiga = $tempKnjiga;
        $this->registry->template->naslov = $tempKnjiga->naziv;

        // Dohvati recenzije
        require_once __SITE_PATH . '/model/review.model.php';
        $reviewModel = new ReviewModel($this->registry->db);
        $recenzije = $reviewModel->getReviews($book_id);
        $this->registry->template->recenzije = $recenzije;
        $prosjek = $reviewModel->izracunajProsjecnuOcjenu($book_id);
        $this->registry->template->prosjek_ocjena = round($prosjek, 2); //racunamo prosjecnu ocjenu


        $korisnik = $_SESSION['username'] ?? null;
        $moze_recenzirati = false;

        if ($korisnik !== null) {
            require_once __SITE_PATH . '/model/userservice.class.php';
            $userModel = new UserService($this->registry->db);
            $user = $userModel->getUserByUsername($korisnik);

            require_once __SITE_PATH . '/model/review.model.php';
            $reviewModel = new ReviewModel($this->registry->db);
            $moze_recenzirati = !$reviewModel->jeliRecenzirao($user->id, $book_id);
        }

        $this->registry->template->moze_recenzirati = $moze_recenzirati;

        $this->registry->template->show('book_details');

    }

    public function recenziraj() {
        if (!isset($_POST['book_id'], $_POST['ocjena'], $_POST['komentar'])) {
            header('Location: ' . __SITE_URL . '/index.php?rt=search');
            exit();
        }

        $book_id = (int)$_POST['book_id'];
        $ocjena = (int)$_POST['ocjena'];
        $komentar = trim($_POST['komentar']);
        $korisnik = $_SESSION['username'] ?? null;

        if ($korisnik === null) {
            header('Location: ' . __SITE_URL . '/index.php?rt=login');
            exit();
        }

        require_once __SITE_PATH . '/model/userservice.class.php';
        $userModel = new UserService($this->registry->db);
        $user = $userModel->getUserByUsername($korisnik);

        require_once __SITE_PATH . '/model/review.model.php';
        $reviewModel = new ReviewModel($this->registry->db);

        if ($reviewModel->jeliRecenzirao($user->id, $book_id)) {
            header('Location: ' . __SITE_URL . '/index.php?rt=bookDetails&temp_book_id=' . $book_id);
            exit();
        }

        $reviewModel->unesiRecenziju($user->id, $book_id, $komentar, $ocjena);

        //  natrag na detalje knjige
        header('Location: ' . __SITE_URL . '/index.php?rt=bookDetails&temp_book_id=' . $book_id);
        exit();
    }


}
?>
