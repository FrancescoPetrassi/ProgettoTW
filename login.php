<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Blog TW - Login";
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["articolicasuali"] = $dbh->getRandomPosts(2);
$templateParams["js"] = array("js/login.js");


require 'template/base.php';
?>