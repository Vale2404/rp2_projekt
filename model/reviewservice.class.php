<?php

class ReviewService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getReviews($book_id) {
        $st = $this->db->prepare('
            SELECT Recenzije.ID_Korisnika, Recenzije.ID_Knjige, Recenzije.Komentar, Recenzije.Ocjena, Korisnici.Username
            FROM Recenzije
            JOIN Korisnici ON Recenzije.ID_Korisnika = Korisnici.ID
            WHERE Recenzije.ID_Knjige = :id
        ');
        $st->execute(['id' => $book_id]);

        $rez = [];
        while ($row = $st->fetch()) {
            $review = new Review(
                $row['ID_Korisnika'],
                $row['ID_Knjige'],
                $row['Komentar'],
                $row['Ocjena']
            );
            $review->username = $row['Username'];
            $rez[] = $review;
        }
        return $rez;
    }

    public function jeliRecenzirao($id_korisnika, $id_knjige) {
        $st = $this->db->prepare('
            SELECT 1 FROM Recenzije 
            WHERE ID_Korisnika = :kor AND ID_Knjige = :knj 
            LIMIT 1
        ');
        $st->execute(['kor' => $id_korisnika, 'knj' => $id_knjige]);
        return $st->fetchColumn() !== false;
    }

    public function unesiRecenziju($id_korisnika, $id_knjige, $komentar, $ocjena) {
        $st = $this->db->prepare('
            INSERT INTO Recenzije (ID_Korisnika, ID_Knjige, Komentar, Ocjena)
            VALUES (:kor, :knj, :kom, :ocj)
        ');
        $st->execute([
            'kor' => $id_korisnika,
            'knj' => $id_knjige,
            'kom' => $komentar,
            'ocj' => $ocjena
        ]);
    }

    public function izracunajProsjecnuOcjenu($book_id) {
        $st = $this->db->prepare('
            SELECT ROUND(AVG(Ocjena), 2) AS prosjek
            FROM Recenzije
            WHERE ID_Knjige = :id
        ');
        $st->execute(['id' => $book_id]);
        $row = $st->fetch();
        $prosjek = $row['prosjek'] ?? null;
        return $prosjek;
    }
}
?>