<?php

class LibraryService {

    public function getAllBooks() {
        try {
			$db = DB::getConnection();
			$st = $db->prepare('SELECT * FROM Knjige');
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
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM Knjige WHERE `ID` = :id');
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
}

?>