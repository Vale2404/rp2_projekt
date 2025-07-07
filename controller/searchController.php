<?php

class SearchController extends BaseController {
    public function index() {
        $ls = new LibraryService();

		// Popuni template potrebnim podacima
		$this->registry->template->naslov = 'Popis svih knjiga';
		$this->registry->template->lista_knjiga = $ls->getAllBooks();

        $this->registry->template->show('books_index');
    }
}

?>