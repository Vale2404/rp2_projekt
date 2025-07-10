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

    public function addBook($Autor, $Naziv, $Zanr, $Slika_naslovnice, $Godina, $Opis) {
        try {
            $st = $this->db->prepare('INSERT INTO Knjige (Autor, Naziv, Zanr, Slika_naslovnice, Godina, Opis, Prosjecna_ocjena) VALUES (:Autor, :Naziv, :Zanr, :Slika_naslovnice, :Godina, :Opis, 0)');
            $st->execute([
                'Autor' => $Autor,
                'Naziv' => $Naziv,
                'Zanr' => $Zanr,
                'Slika_naslovnice' => $Slika_naslovnice,
                'Godina' => $Godina,
                'Opis' => $Opis
            ]);
        } catch (PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
    }

    public function deleteBook($book_id) {
        try {
            $st = $this->db->prepare('DELETE FROM Knjige where id=?');
            $st->execute([$book_id]);
        } catch (PDOException $e) {
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

    public function getReadList($user_id) {
        try {
            $st = $this->db->prepare('SELECT k.* FROM Knjige k INNER JOIN Procitane p ON k.ID = p.ID_Knjige WHERE p.ID_Korisnika = :user_id');
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

    public function updateBook($id, $atribut, $vrijednost) {
        $dozvoljeniAtributi = ['Autor', 'Naziv', 'Zanr', 'Slika_naslovnice', 'Godina', 'Opis'];
        if(!in_array($atribut, $dozvoljeniAtributi)) {
            throw new Exception('Neispravan atribut!');
        }
        try {
            $sql = "UPDATE Knjige SET $atribut = :vrijednost WHERE ID = :id";
			$st = $this->db->prepare($sql);
			$st->execute(['vrijednost' => $vrijednost, 'id' => $id]);
        } catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
    }
}

?>