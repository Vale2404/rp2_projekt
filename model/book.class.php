<?php

class Book {
	protected $id, $autor, $naziv, $zanr, $slika_naslovnice, $godina, $opis, $prosjecna_ocjena;

	function __construct($id, $autor, $naziv, $zanr, $slika_naslovnice, $godina, $opis, $prosjecna_ocjena) {
		$this->id = $id;
        $this->autor = $autor;
        $this->naziv = $naziv;
		$this->zanr = $zanr;
		$this->slika_naslovnice = $slika_naslovnice;
		$this->godina = $godina;
        $this->opis = $prosjecna_ocjena;
        $this->library = $prosjecna_ocjena;
	}

	function __get($prop) {
        return $this->$prop;
    }
	function __set($prop, $val) {
        $this->$prop = $val;
        return $this;
    }
}

?>