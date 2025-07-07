<?php

class User {
	protected $id, $ime, $prezime, $username, $password_hash, $mail;

	function __construct($id, $ime, $prezime, $username, $password_hash, $mail) {
		$this->id = $id;
        $this->ime = $ime;
        $this->prezime = $prezime;
		$this->username = $username;
		$this->password_hash = $password_hash;
        $this->mail = $mail;
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