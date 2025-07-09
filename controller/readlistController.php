<?php

class ReadlistController extends BaseController {
    public function index() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?rt=login');
            exit();
        }
        $user_id = $_SESSION['user_id'];
        $ls = new LibraryService($this->registry->db);

        $readlist = $ls->getReadList($user_id);

		$this->registry->template->naslov = 'Popis pročitanih knjiga';
		$this->registry->template->readlist = $readlist;

        $this->registry->template->show('readlist');
    }

    //Dodaj knjigu na listu procitanih
    public function add() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?rt=login');
            exit();
        }
        if(!isset($_POST['book_id_readlist'])) {
            header('Location: index.php?rt=search');
            exit();
        }
        $user_id = $_SESSION['user_id'];
        $book_id = intval($_POST['book_id_readlist']);

        $ls = new LibraryService($this->registry->db);
        $ls->addBookToReadList($user_id, $book_id);

        //Nakon dodavanja vrati korisnika na read listu
        header('Location: index.php?rt=readlist');
        exit();
    }

    //Ukloni knjigu s liste želja
    public function delete() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?rt=login');
            exit();
        }
        if(!isset($_POST['book_id_readlist'])) {
            header('Location: index.php?rt=readlist');
            exit();
        }
        $user_id = $_SESSION['user_id'];
        $book_id = intval($_POST['book_id_readlist']);

        $ls = new LibraryService($this->registry->db);
        $ls->deleteBookFromReadList($user_id, $book_id);

        header('Location: index.php?rt=readlist');
        exit();
    }
}

?>