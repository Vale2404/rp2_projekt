<?php

class LibraryService {

    private $db;

     public function __construct($db) {
        $this->db = $db;
    }

    public function getAllBooks() {
        try {
			$st = $this->db->prepare('SELECT * FROM Knjige');
			$st->execute();
        } catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
        $arr = array();
		while($row = $st->fetch()) {
			$arr[] = new Book(
                $row['ID'],
                $row['Autor'],
                $row['Naziv'],
                $row['Zanr'],
                $row['Slika_naslovnice'], 
                $row['Godina'],
                $row['Opis'],
                $row['Prosjecna_ocjena']
            );
        }
		return $arr;
    }

    public function getBook($temp_book_id) {
        try {
            $st = $this->db->prepare('SELECT * FROM Knjige WHERE `ID` = :id');
            $st->execute(['id' => $temp_book_id]);
            $row = $st->fetch();
            if ($row === false) {
                // Nema knjige s tim ID-em!
                return null;
            }
            return new Book(
                $row['ID'],
                $row['Autor'],
                $row['Naziv'],
                $row['Zanr'],
                $row['Slika_naslovnice'],
                $row['Godina'],
                $row['Opis'],
                $row['Prosjecna_ocjena']
            );
        } catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
    }

    public function getWishList($user_id) {
        try {
            $st = $this->db->prepare('SELECT k.* FROM Knjige k INNER JOIN Zelje z ON k.ID = z.ID_Knjige WHERE z.ID_Korisnika = :user_id');
            $st->execute(['user_id' => $user_id]);
        } catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
        $arr = array();
        while($row = $st->fetch()) {
            $arr[] = new Book(
                $row['ID'],
                $row['Autor'],
                $row['Naziv'],
                $row['Zanr'],
                $row['Slika_naslovnice'], 
                $row['Godina'],
                $row['Opis'],
                $row['Prosjecna_ocjena']
            );
        }
        return $arr;
    }

    public function addBookToWishList($user_id, $book_id) {
        try {
			$st = $this->db->prepare('INSERT IGNORE INTO Zelje (ID_Korisnika, ID_Knjige) VALUES (?, ?)');
			$st->execute([$user_id, $book_id]);
        } catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
    }

    public function deleteBookFromWishList($user_id, $book_id) {
        try {
			$st = $this->db->prepare('DELETE FROM Zelje WHERE ID_Korisnika = :user_id AND ID_Knjige = :book_id');
			$st->execute(['user_id' => $user_id, 'book_id' => $book_id]);
        } catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
    }

    public function addBookToReadList($user_id, $book_id) {
        try {
			$st = $this->db->prepare('INSERT IGNORE INTO Procitane (ID_Korisnika, ID_Knjige) VALUES (?, ?)');
			$st->execute([$user_id, $book_id]);
        } catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
    }

    public function deleteBookFromReadList($user_id, $book_id) {
        try {
			$st = $this->db->prepare('DELETE FROM Procitane WHERE ID_Korisnika = :user_id AND ID_Knjige = :book_id');
			$st->execute(['user_id' => $user_id, 'book_id' => $book_id]);
        } catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
    }
}

?>