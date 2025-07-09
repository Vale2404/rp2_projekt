<?php
require_once 'model/user.class.php';

class UserService {
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

        $st = $this->db->prepare('INSERT INTO Korisnici (Ime, Prezime, Username, Password_Hash, Mail, jel_admin)
                                VALUES (:ime, :prezime, :username, :password, :mail, :jel_admin)');
        $st->execute([
            'ime' => $ime,
            'prezime' => $prezime,
            'username' => $username,
            'password' => $hash,
            'mail' => $email,
            'jel_admin' => 0
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
            $row['jel_admin']
        );
    }
}
?>
