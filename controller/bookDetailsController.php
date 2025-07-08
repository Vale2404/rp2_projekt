<?php

class BookDetailsController extends BaseController {
    public function index() {

        $book_id = (int)($_GET["temp_book_id"] ?? 0);
        $ls = new LibraryService();
        $tempKnjiga = $ls->getBook($book_id);
        

        $this->registry->template->knjiga = $tempKnjiga;
        $this->registry->template->naslov = $tempKnjiga->naziv;

        // Dohvati recenzije
        require_once __SITE_PATH . '/model/review.model.php';
        $reviewModel = new ReviewModel($this->registry->db);
        $recenzije = $reviewModel->getReviews($book_id);
        $this->registry->template->recenzije = $recenzije;

        $korisnik = $_SESSION['username'] ?? null;
        $moze_recenzirati = false;

        if ($korisnik !== null) {
            require_once __SITE_PATH . '/model/UserModel.php';
            $userModel = new UserModel($this->registry->db);
            $user = $userModel->getUserByUsername($korisnik);

            require_once __SITE_PATH . '/model/ReviewModel.php';
            $reviewModel = new ReviewModel($this->registry->db);
            $moze_recenzirati = !$reviewModel->jeliRecenzirao($user->id, $book_id);
        }

        $this->registry->template->moze_recenzirati = $moze_recenzirati;

        $this->registry->template->show('book_details');

    }
}
?>
