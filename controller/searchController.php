<?php
//session_start();

class SearchController extends BaseController {
    public function index() {
        $ls = new LibraryService($this->registry->db);

		// Popuni template potrebnim podacima
		$this->registry->template->lista_knjiga = $ls->getAllBooks();

        $_SESSION["wishlistIDs"] = [];
        if(isset($_SESSION['user_id'])) {
            $wishlist = $ls->getWishList($_SESSION['user_id']);
            foreach ($wishlist as $book) {
                $_SESSION["wishlistIDs"][] = $book->id;
            }
        }

        $_SESSION["readlistIDs"] = [];
        if(isset($_SESSION['user_id'])) {
            $readlist = $ls->getReadList($_SESSION['user_id']);
            foreach ($readlist as $book) {
                $_SESSION["readlistIDs"][] = $book->id;
            }
        }

        $this->registry->template->allGenres = $ls->getAllGenres();
		$this->registry->template->naslov = 'Pregled svih knjiga';
        $this->registry->template->show('books_index');
    }

    public function searchAndFilter()
    {
        $_SESSION['searchText'] = $_POST['searchText'] ?? "";
        $_SESSION['sortOption'] = $_POST['sortOption'] ?? "";
        $_SESSION['checkedGenres'] = $_POST['checkedGenres'] ?? [];

        $ls = new LibraryService($this->registry->db);
        $indexiFiltriranih = $ls->getBySearchAndFilter($_SESSION['searchText'], $_SESSION['sortOption'], $_SESSION['checkedGenres']);

        $filtriraneKnjige = [];
        foreach ($indexiFiltriranih as $i) {
            $knjiga = $ls->getBook($i);
            $filtriraneKnjige[] = $knjiga;
        }

        $this->registry->template->lista_knjiga = $filtriraneKnjige;
        $this->registry->template->allGenres = $ls->getAllGenres();
        $this->registry->template->naslov = 'Pregled knjiga - filtrirano';
        $this->registry->template->show('books_index');        
    }

    public function resetSearch()
    {
        unset($_SESSION['checkedGenres'], $_SESSION['searchText'], $_SESSION['sortOption']);
        header('Location: index.php?rt=search');
        exit();
    }

}

?>