<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

    public function getAllUsers() {
        try {
			$st = $this->db->prepare('SELECT * FROM Korisnici');
			$st->execute();
        } catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
        $arr = array();
		while($row = $st->fetch()) {
			$arr[] = new User(
                $row['ID'],
                $row['Ime'],
                $row['Prezime'],
                $row['Username'],
                $row['Password_Hash'], 
                $row['Mail'],
                $row['jel_admin']
            );
        }
		return $arr;
    }

    public function deleteUser($user_id) {
        try {
            $st = $this->db->prepare('SELECT jel_admin FROM Korisnici WHERE ID = :id');
            $st->execute(['id' => $user_id]);
            $korisnik = $st->fetch();

            if(!$korisnik) 
                exit('Korisnik ne postoji!');

            if($korisnik['jel_admin'] == 1 && $_SESSION['user_id'] != $user_id) 
                exit('Ne možete obrisati drugog admina!');

			$st = $this->db->prepare('DELETE FROM Recenzije WHERE ID_Korisnika = :id');
			$st->execute(['id' => $user_id]);

            $st = $this->db->prepare('DELETE FROM Zelje WHERE ID_Korisnika = :id');
			$st->execute(['id' => $user_id]);

            $st = $this->db->prepare('DELETE FROM Procitane WHERE ID_Korisnika = :id');
			$st->execute(['id' => $user_id]);

            $st = $this->db->prepare('DELETE FROM Korisnici WHERE ID = :id');
			$st->execute(['id' => $user_id]);
        } catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
    }
}
?>
