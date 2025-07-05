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
}

?>