<?php

class BookDetailsController extends BaseController {
    public function index() {

        $ls = new LibraryService();
        // Book Object ( [id:protected] => 1 [autor:protected] => George Orwell [naziv:protected] => 1984 [zanr:protected] => Roman [slika_naslovnice:protected] => 1984.jpg [godina:protected] => 1949 [opis:protected] => 4.5 [prosjecna_ocjena:protected] => [library] => 4.5 ) 
		$tempKnjiga = $ls->getBook((int)$_GET["temp_book_id"]);
        $this->registry->template->knjiga = $tempKnjiga;

        $this->registry->template->naslov = $tempKnjiga->naziv;
        $this->registry->template->show('book_details');
    }
}

?>