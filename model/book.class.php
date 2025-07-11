<?php

class Book implements JsonSerializable {
	protected $id, $autor, $naziv, $zanr, $slika_naslovnice, $godina, $opis, $prosjecna_ocjena;

	function __construct($id, $autor, $naziv, $zanr, $slika_naslovnice, $godina, $opis, $prosjecna_ocjena) {
		$this->id = $id;
        $this->autor = $autor;
        $this->naziv = $naziv;
		$this->zanr = $zanr;
		$this->slika_naslovnice = $slika_naslovnice;
		$this->godina = $godina;
        $this->opis = $opis;
        $this->prosjecna_ocjena = $prosjecna_ocjena;
	}

	function __get($prop) {
        return $this->$prop;
    }
	function __set($prop, $val) {
        $this->$prop = $val;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'Id' => $this->id,
            'Autor' => $this->autor,
            'Naziv' => $this->naziv,
            'Zanr' => $this->zanr,
            'Slika_naslovnice' => $this->slika_naslovnice,
            'Godina' => $this->godina,
            'Opis' => $this->opis,
            'Prosjecna_ocjena' => $this->prosjecna_ocjena
        ];
    }
}

?>