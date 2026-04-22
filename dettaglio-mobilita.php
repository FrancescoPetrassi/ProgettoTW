<?php
require_once 'bootstrap.php';

$id_mobilita = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_mobilita === 0) {
    header("Location: archivio-mobilita.php");
    exit();
}

$mobilitaData = $dbh->getMobilitaById($id_mobilita);
if (empty($mobilitaData)) {
    header("Location: archivio-mobilita.php");
    exit();
}

$mobilita = $mobilitaData[0];
$utenteAlreadyCandidated = false;
$messaggio = '';
$messaggioTipo = 'success';

if (isUserLoggedInErasmus()) {
    $id_utente = $_SESSION['id_utente'];
    $candidatureUtente = $dbh->getCandidatureUtente($id_utente);
    foreach ($candidatureUtente as $candidatura) {
        if ($candidatura['id_mobilita'] == $id_mobilita) {
            $utenteAlreadyCandidated = true;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isUserLoggedInErasmus()) {
        $messaggio = 'Devi essere loggato per candidarti a una mobilità.';
        $messaggioTipo = 'danger';
    } elseif ($utenteAlreadyCandidated) {
        $messaggio = 'Hai già una candidatura in corso per questa mobilità.';
        $messaggioTipo = 'warning';
    } else {
        $id_utente = $_SESSION['id_utente'];
        if ($dbh->inserisciCandidatura($id_utente, $id_mobilita)) {
            $messaggio = 'Candidatura inviata con successo! Puoi controllare lo stato nella tua dashboard.';
            $messaggioTipo = 'success';
            $utenteAlreadyCandidated = true;
        } else {
            $messaggio = 'Errore durante l\'invio della candidatura. Riprova più tardi.';
            $messaggioTipo = 'danger';
        }
    }
}

$templateParams["titolo"] = "Dettaglio Mobilità - " . htmlspecialchars($mobilita['titolo']) . " - Erasmus Mobility Manager";
$templateParams["nome"] = "template/dettaglio-mobilita.php";
$templateParams["mobilita"] = $mobilita;
$templateParams["messaggio"] = $messaggio;
$templateParams["messaggioTipo"] = $messaggioTipo;
$templateParams["utenteAlreadyCandidated"] = $utenteAlreadyCandidated;
$templateParams["isLoggedIn"] = isUserLoggedInErasmus();

require 'template/base-erasmus.php';
?>