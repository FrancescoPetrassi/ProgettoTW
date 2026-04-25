<?php
session_start();
define("UPLOAD_DIR", "./upload/");
require_once("utils/functions.php");
require_once("db/database.php");


$DB_NAME = "erasmus_db"; 
$dbh = new DatabaseHelper("localhost", "root", "", $DB_NAME, 3306);
?>
