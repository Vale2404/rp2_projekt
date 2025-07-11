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
    public function getTopRatedBooks($broj) {  //biramo hoce biti top 5,10...
        $st = $this->db->prepare(
            'SELECT k.*, AVG(r.Ocjena) AS prosjek
            FROM Knjige k
            JOIN Recenzije r ON k.ID = r.ID_Knjige
            GROUP BY k.ID
            ORDER BY prosjek DESC
            LIMIT :broj'
        );
        $st->bindValue(':broj', $broj, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll();
    }

    public function getMostPopularBooks($broj) {
        $st = $this->db->prepare(
            'SELECT k.*, 
                (SELECT COUNT(*) FROM Zelje z WHERE z.ID_Knjige = k.ID) +
                (SELECT COUNT(*) FROM Procitane p WHERE p.ID_Knjige = k.ID) AS popularnost
            FROM Knjige k
            ORDER BY popularnost DESC
            LIMIT :broj'
        );
        $st->bindValue(':broj', $broj, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll();
    }

    function getBySearchAndFilter( $search = '', $sort = '', $genre = [])
    {
        $query = 'SELECT `ID` FROM `Knjige`';
        if($search !== '' || !empty($genre))
            $query .= ' WHERE ';

        if ($search !== '') {
            $query .= '(`Naziv` LIKE :naziv_djela OR `Autor` LIKE :ime_autora)';
        }
        if (!empty($genre))
        {
            if ($search !== '')
                $query .= ' AND ';

            $query .= '`Zanr` IN (' . implode(', ', array_map([$this->db, 'quote'], $genre)) . ')';
        }
        if ($sort !== '') {
            $query .= ' ORDER BY ' . $sort;
        }
        $st = $this->db->prepare($query);

        if ($search !== '') {
            $search = '%' . $search . '%';
            $st->bindValue(':naziv_djela', $search, PDO::PARAM_STR);
            $st->bindValue(':ime_autora', $search, PDO::PARAM_STR);
        }
        $st->execute();

        $indexi = [];
        while ($row = $st->fetch()) {
            $indexi[] = (int) $row['ID'];
        }

        return $indexi;
    }
    
    function getAllGenres()
    {
        $st = $this->db->prepare('SELECT DISTINCT Zanr FROM Knjige WHERE Zanr IS NOT NULL AND Zanr != \'\' ORDER BY Zanr');
        $st->execute();
        return $st->fetchAll(PDO::FETCH_COLUMN, 0);
    }

}
?>