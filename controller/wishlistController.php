<?php

class WishlistController extends BaseController {
    public function index() {
        $ls = new LibraryService();

		$this->registry->template->naslov = 'Popis knjiga za pročitati';
		$this->registry->template->wishlist = [];

        $this->registry->template->show('wishlist');
    }
}

?>