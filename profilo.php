<?php
require_once 'bootstrap.php';

redirectIfNotLoggedIn();
$id_utente = $_SESSION['id_utente'];
$utenteData = $dbh->getUtenteById($id_utente);
$utente = !empty($utenteData) ? $utenteData[0] : array();

$profiloMsg = '';
$profiloMsgType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = sanitizeInput($_POST['nome'] ?? '');
    $cognome = sanitizeInput($_POST['cognome'] ?? '');
    $universita = sanitizeInput($_POST['universita'] ?? '');

    if (empty($nome) || empty($cognome)) {
        $profiloMsg = 'Nome e cognome sono obbligatori.';
        $profiloMsgType = 'danger';
    } else {
        if ($dbh->aggiornaUtente($id_utente, $nome, $cognome, $universita)) {
            $_SESSION['nome'] = $nome;
            $_SESSION['cognome'] = $cognome;
            $utente['nome'] = $nome;
            $utente['cognome'] = $cognome;
            $utente['universita'] = $universita;
            $profiloMsg = 'Profilo aggiornato con successo.';
            $profiloMsgType = 'success';
        } else {
            $profiloMsg = 'Errore durante l\'aggiornamento del profilo. Riprovare.';
            $profiloMsgType = 'danger';
        }
    }
}

$templateParams["titolo"] = "Profilo Utente - Erasmus Mobility Manager";
$templateParams["nome"] = "template/profilo-utente.php";
$templateParams["utente"] = $utente;
$templateParams["profiloMsg"] = $profiloMsg;
$templateParams["profiloMsgType"] = $profiloMsgType;

require 'template/base-erasmus.php';
?>