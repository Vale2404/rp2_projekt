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

		$this->registry->template->naslov = 'Pregled svih knjiga';
        $this->registry->template->show('books_index');
    }

    public function searchAndFilter()
    {
        $selectedGenres = $_POST['checkedGenres'] ?? [];
        $searchText = $_POST["searchText"] ?? "";
        $sortOption = $_POST["sortOption"] ?? "";

/*
        print_r($_POST['checkedGenres']);
        print($_POST["searchText"]);
        print($_POST["sortOption"]);
        exit();
 */

        $ls = new LibraryService($this->registry->db);
        $indexiFiltriranih = $ls->getBySearchAndFilter($searchText, $sortOption, $selectedGenres);

        $filtriraneKnjige = [];
        foreach ($indexiFiltriranih as $i) {
            $knjiga = $ls->getBook($i);
            $filtriraneKnjige[] = $knjiga;
        }

        $this->registry->template->lista_knjiga = $filtriraneKnjige;
        $this->registry->template->naslov = 'Pregled knjiga - filtrirano';
        $this->registry->template->show('books_index');        
    }
}

?>