<?php
require_once 'model/libraryservice.class.php';

class PopularController extends BaseController{
    private $library;

    public function __construct($registry) {
        parent::__construct($registry);
        $this->library = new LibraryService($registry->db);
    }

    public function index() {
        $topRated = $this->library->getTopRatedBooks(5);
        $mostPopular = $this->library->getMostPopularBooks(5);

        $this->registry->template->topRated = $topRated;
        $this->registry->template->mostPopular = $mostPopular;
        $this->registry->template->naslov = 'Najpopularnije knjige';
        $this->registry->template->show('popular_books');
    }
}

?>