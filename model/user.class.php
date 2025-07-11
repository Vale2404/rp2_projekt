<?php

class User implements JsonSerializable {
	protected $id, $ime, $prezime, $username, $password_hash, $mail, $jel_admin;

	function __construct($id, $ime, $prezime, $username, $password_hash, $mail, $jel_admin) {
		$this->id = $id;
        $this->ime = $ime;
        $this->prezime = $prezime;
		$this->username = $username;
		$this->password_hash = $password_hash;
        $this->mail = $mail;
        $this->jel_admin = $jel_admin;
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
            'ID' => $this->id,
            'Ime' => $this->ime,
            'Prezime' => $this->prezime,
            'Username' => $this->username,
            'Pasword_Hash' => $this->password_hash,
            'Mail' => $this->mail,
            'jel_admin' => $this->jel_admin
        ];
    }
}

?>