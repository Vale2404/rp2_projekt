<?php

class MyreviewsController extends BaseController {
    public function index() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?rt=login');
            exit();
        }
        
        $user_id = $_SESSION['user_id'];
        $ls = new LibraryService($this->registry->db);

        $this->registry->template->naslov = 'Pregled mojih recenzija';
        $this->registry->template->mojeRecenzije = $ls->getAllCommentsFromUser($user_id);
        $this->registry->template->neocijenjeneKnjige = $ls->getAllReadButNotReviewedBooks($user_id);

        $this->registry->template->show('myreviews');
    }

    public function deleteReview() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?rt=login');
            exit();
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = intval($_POST['user_id']);
            $book_id = intval($_POST['book_id']);
            $ls = new LibraryService($this->registry->db);
            $ls->deleteReview($user_id, $book_id);
        }
        header('Location: index.php?rt=myreviews');
        exit();
    }
}

?>