<?php
require_once __DIR__ . '/app/database/db.class.php';
require_once 'controller/RegisterController.php';

session_start();

$db = DB::getConnection();
$controller = new RegisterController($db);
$controller->register();
?>