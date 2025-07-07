<?php

class WishlistController extends BaseController {
    public function index() {
         if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?rt=login');
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $ls = new LibraryService($this->registry->db);

        $wishlist = $ls->getWishList($user_id);


		$this->registry->template->naslov = 'Popis knjiga za pročitati';
		$this->registry->template->wishlist = $wishlist;

        $this->registry->template->show('wishlist');
    }

     //Dodaj knjigu na listu želja
    public function add() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?rt=login');
            exit();
        }
        if(!isset($_POST['book_id'])) {
            header('Location: index.php?rt=search');
            exit();
        }
        $user_id = $_SESSION['user_id'];
        $book_id = intval($_POST['book_id']);

        $ls = new LibraryService($this->registry->db);
        $ls->addBookToWishList($user_id, $book_id);

        //Nakon dodavanja vrati korisnika na wishlistu
        header('Location: index.php?rt=wishlist');
        exit();
    }

    //Ukloni knjigu s liste želja
    public function delete() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?rt=login');
            exit();
        }
        if(!isset($_POST['book_id'])) {
            header('Location: index.php?rt=wishlist');
            exit();
        }
        $user_id = $_SESSION['user_id'];
        $book_id = intval($_POST['book_id']);

        $ls = new LibraryService($this->registry->db);
        $ls->deleteBookFromWishList($user_id, $book_id);

        header('Location: index.php?rt=wishlist');
        exit();
    }
}

?>