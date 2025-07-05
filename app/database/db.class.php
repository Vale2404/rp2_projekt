<?php

class DB {
    private static $db = null;
    
    private function __construct() { }
    private function __clone() { }

    public static function getConnection() {
        if(DB::$db === null) {
			$db_base = 'mysql:host=rp2.studenti.math.hr;dbname=pavicic;charset=utf8';
            $db_user = 'student';
            $db_pass = 'pass.mysql';
			try {
				DB::$db = new PDO($db_base, $db_user, $db_pass);
				
				// Ako želimo da funkcije poput prepare, execute bacaju exceptione:
				DB::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    	DB::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			}
			catch(PDOException $e) {
                exit('Greška prilikom spajanja na bazu:' . $e->getMessage());
            }
		}
        return DB::$db;
    }
} 

?>