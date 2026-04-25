<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Contatti - Erasmus Mobility Manager";
$templateParams["nomefile"] = "template/contatti-erasmus.php";

$templateParams["university_list"] = $dbh->getUniversita();

require 'template/base-erasmus.php';