<?php
session_start();
define("UPLOAD_DIR", "./upload/");
require_once("utils/functions.php");
require_once("db/database.php");

// Connessione al database - Supporto per vecchio schema (blogtw) e nuovo (erasmus_db)
// Se vuoi usare il nuovo schema Erasmus, cambia 'blogtw' in 'erasmus_db'
$DB_NAME = "erasmus_db"; // Cambiato da "blogtw" a "erasmus_db" per il nuovo schema
$dbh = new DatabaseHelper("localhost", "root", "", $DB_NAME, 3306);
?>