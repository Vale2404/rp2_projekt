<?php

class User {
	protected $id, $ime, $prezime, $username, $password_hash, $mail, $lista_zelja, $lista_procitano;

	function __construct($id, $ime, $prezime, $username, $password_hash, $mail, $lista_zelja, $lista_procitano) {
		$this->id = $id;
        $this->ime = $ime;
        $this->prezime = $prezime;
		$this->username = $username;
		$this->password_hash = $password_hash;
        $this->mail = $mail;
        $this->lista_zelja = $lista_zelja;
        $this->lista_procitano = $lista_procitano;
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