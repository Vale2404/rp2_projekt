<?php

class SearchController extends BaseController {
    public function index() {
        $ls = new LibraryService();

		// Popuni template potrebnim podacima
		$this->registry->template->naslov = 'Popis svih knjiga';
		$this->registry->template->lista_knjiga = $ls->getAllBooks();

        $wishlist_ids = [];
        if(isset($_SESSION['user_id'])) {
            $wishlist = $ls->getWishList($_SESSION['user_id']);
            foreach ($wishlist as $book) {
                $wishlist_ids[] = $book->id;
            }
        }

        $this->registry->template->wishlist_ids = $wishlist_ids;

        $this->registry->template->show('books_index');
    }
}

?>