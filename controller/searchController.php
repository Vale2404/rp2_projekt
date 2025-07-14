<?php
//session_start();

class SearchController extends BaseController {
    public function index() {
        $ls = new LibraryService($this->registry->db);

        if (isset($_POST['searchText']))    $_SESSION['searchText'] = $_POST['searchText'];
        $_SESSION['sortOption'] = $_POST['sortOption'] ?? "";
        if (isset($_POST['checkedGenres']))    $_SESSION['checkedGenres'] = $_POST['checkedGenres'];
        $this->registry->template->lista_knjiga = $ls->getBySearchAndFilter($_SESSION['searchText'] ?? "", $_SESSION['sortOption'] ?? "", $_SESSION['checkedGenres'] ?? "");
        $this->registry->template->allGenres = $ls->getAllGenres();

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

		$this->registry->template->naslov = 'Pretraga knjiga';
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