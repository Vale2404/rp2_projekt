<?php
require_once 'model/user.class.php';

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public function userExists($username) {
        $st = $this->db->prepare('SELECT * FROM Korisnici WHERE username = :username');
        $st->execute(['username' => $username]);
        return $st->rowCount() > 0;
    }

    public function registerUser($ime, $prezime, $username, $password, $email) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $st = $this->db->prepare('INSERT INTO Korisnici (Ime, Prezime, Username, Password_Hash, Mail, Lista_zelja, Lista_procitano)
                                VALUES (:ime, :prezime, :username, :password, :mail, :lista_zelja, :lista_procitano)');
        $st->execute([
            'ime' => $ime,
            'prezime' => $prezime,
            'username' => $username,
            'password' => $hash,
            'mail' => $email,
            'lista_zelja' => '',
            'lista_procitano' => ''
        ]);
    }

    public function getUserByUsername($username) {
        $st = $this->db->prepare('SELECT * FROM Korisnici WHERE Username = :username');
        $st->execute(['username' => $username]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->mapRowToUser($row) : null;
    }

    //mapira red baze u objekt klase User
    private function mapRowToUser($row) {
        return new User(
            $row['ID'],
            $row['Ime'],
            $row['Prezime'],
            $row['Username'],
            $row['Password_Hash'],
            $row['Mail'],
            $row['Lista_zelja'],
            $row['Lista_procitano']
        );
    }
}
?>
