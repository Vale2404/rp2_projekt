<?php

class ReadingHistoryController extends BaseController {
    public function index() {
        $ls = new LibraryService();

		$this->registry->template->naslov = 'Popis pročitanih knjiga';
		$this->registry->template->readingHistory = [];

        $this->registry->template->show('readingHistory');
    }
}

?>