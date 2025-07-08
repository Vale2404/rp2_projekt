<?php

class Review {
	protected $id_korisnika, $id_knjige, $komentar, $ocjena;

	function __construct($id_korisnika, $id_knjige, $komentar, $ocjena) {
        $this->id_korisnika = $id_korisnika;
        $this->id_knjige = $id_knjige;
		$this->komentar = $komentar;
		$this->ocjena = $ocjena;
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