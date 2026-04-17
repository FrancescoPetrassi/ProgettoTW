<?php
require_once 'bootstrap.php';

redirectIfNotLoggedIn();
$id_utente = $_SESSION['id_utente'];
$utenteData = $dbh->getUtenteById($id_utente);
$utente = !empty($utenteData) ? $utenteData[0] : array();
$candidature = $dbh->getCandidatureUtente($id_utente);

$totaleCandidature = count($candidature);
$inAttesa = 0;
$approvate = 0;
$rifiutate = 0;
foreach ($candidature as $candidatura) {
    switch ($candidatura['stato']) {
        case 'in_attesa':
            $inAttesa++;
            break;
        case 'approvato':
            $approvate++;
            break;
        case 'rifiutato':
            $rifiutate++;
            break;
    }
}

$templateParams["titolo"] = "Dashboard Utente - Erasmus Mobility Manager";
$templateParams["nome"] = "template/dashboard-utente.php";
$templateParams["candidature"] = $candidature;
$templateParams["utente"] = $utente;
$templateParams["totaleCandidature"] = $totaleCandidature;
$templateParams["inAttesa"] = $inAttesa;
$templateParams["approvate"] = $approvate;
$templateParams["rifiutate"] = $rifiutate;

require 'template/base-erasmus.php';
?>