<?php

require_once "classes/Database.php";


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'reserveringssysteem';

$db = new \Database\Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$connection = $db->getConnection();

if (!$connection){
    echo "FOUT: geen connectie naar database. <br>";
    echo "Errno: " . mysqli_connect_errno() .  "<br/>";
    echo "Error: " . mysqli_connect_error() . "<br/>";
    exit;
}
?>

