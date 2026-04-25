<?php
require_once 'bootstrap.php';

redirectIfNotAdmin();

$messaggio = '';
$messaggioTipo = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? sanitizeInput($_POST['action']) : '';

    if ($action === 'create_mobilita') {
        $titolo = sanitizeInput($_POST['titolo'] ?? '');
        $descrizione = sanitizeInput($_POST['descrizione'] ?? '');
        $id_universita = isset($_POST['id_universita']) ? (int)$_POST['id_universita'] : 0;
        $tipo = sanitizeInput($_POST['tipo'] ?? '');
        $durata = isset($_POST['durata']) ? (int)$_POST['durata'] : 0;
        $data_inizio = sanitizeInput($_POST['data_inizio'] ?? '');
        $data_fine = sanitizeInput($_POST['data_fine'] ?? '');
        $posti = isset($_POST['posti']) ? (int)$_POST['posti'] : 0;
        $requisiti = sanitizeInput($_POST['requisiti'] ?? '');
        $lingue = sanitizeInput($_POST['lingue'] ?? '');

        if (empty($titolo) || empty($descrizione) || $id_universita === 0 || empty($tipo) || $durata <= 0 || empty($data_inizio) || empty($data_fine) || $posti <= 0) {
            $messaggio = 'Compila tutti i campi obbligatori per creare una mobilità.';
            $messaggioTipo = 'danger';
        } else {
            if ($dbh->inserisciMobilita($titolo, $descrizione, $id_universita, $tipo, $durata, $data_inizio, $data_fine, $posti, $requisiti, $lingue)) {
                $messaggio = 'Mobilità creata con successo.';
                $messaggioTipo = 'success';
            } else {
                $messaggio = 'Errore durante la creazione della mobilità.';
                $messaggioTipo = 'danger';
            }
        }
    } elseif ($action === 'update_mobilita') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $titolo = sanitizeInput($_POST['titolo'] ?? '');
        $descrizione = sanitizeInput($_POST['descrizione'] ?? '');
        $posti = isset($_POST['posti']) ? (int)$_POST['posti'] : 0;
        $data_inizio = sanitizeInput($_POST['data_inizio'] ?? '');
        $data_fine = sanitizeInput($_POST['data_fine'] ?? '');
        $attiva = isset($_POST['attiva']) ? (int)$_POST['attiva'] : 0;

        if ($id === 0 || empty($titolo) || empty($descrizione) || $posti < 0 || empty($data_inizio) || empty($data_fine)) {
            $messaggio = 'Compila tutti i campi obbligatori per aggiornare la mobilità.';
            $messaggioTipo = 'danger';
        } else {
            if ($dbh->aggiornaMobilita($id, $titolo, $descrizione, $posti, $data_inizio, $data_fine, $attiva)) {
                $messaggio = 'Mobilità aggiornata con successo.';
                $messaggioTipo = 'success';
            } else {
                $messaggio = 'Errore durante l\'aggiornamento della mobilità.';
                $messaggioTipo = 'danger';
            }
        }
    } elseif ($action === 'create_universita') {
        $nome = sanitizeInput($_POST['nome'] ?? '');
        $paese = sanitizeInput($_POST['paese'] ?? '');
        $citta = sanitizeInput($_POST['citta'] ?? '');
        $descrizione = sanitizeInput($_POST['descrizione'] ?? '');
        $sito_web = sanitizeInput($_POST['sito_web'] ?? '');
        $email = sanitizeInput($_POST['email'] ?? '');

        if (empty($nome) || empty($paese) || empty($citta) || empty($descrizione) || empty($email) || !validateEmail($email)) {
            $messaggio = 'Compila tutti i campi obbligatori e inserisci un email valida per l\'università.';
            $messaggioTipo = 'danger';
        } else {
            if ($dbh->inserisciUniversita($nome, $paese, $citta, $descrizione, $sito_web, $email)) {
                $messaggio = 'Università aggiunta con successo.';
                $messaggioTipo = 'success';
            } else {
                $messaggio = 'Errore durante l\'inserimento dell\'università.';
                $messaggioTipo = 'danger';
            }
        }
    } elseif ($action === 'update_universita') {
        $id_universita = isset($_POST['id_universita']) ? (int)$_POST['id_universita'] : 0;
        $nome = sanitizeInput($_POST['nome'] ?? '');
        $paese = sanitizeInput($_POST['paese'] ?? '');
        $citta = sanitizeInput($_POST['citta'] ?? '');
        $descrizione = sanitizeInput($_POST['descrizione'] ?? '');
        $sito_web = sanitizeInput($_POST['sito_web'] ?? '');
        $email = sanitizeInput($_POST['email'] ?? '');
        $attiva = isset($_POST['attiva']) ? (int)$_POST['attiva'] : 0;

        if ($id_universita === 0 || empty($nome) || empty($paese) || empty($citta) || empty($descrizione) || empty($email) || !validateEmail($email)) {
            $messaggio = 'Compila tutti i campi obbligatori e inserisci un email valida per aggiornare l\'università.';
            $messaggioTipo = 'danger';
        } else {
            if ($dbh->aggiornaUniversita($id_universita, $nome, $paese, $citta, $descrizione, $sito_web, $email, $attiva)) {
                $messaggio = 'Università aggiornata con successo.';
                $messaggioTipo = 'success';
            } else {
                $messaggio = 'Errore durante l\'aggiornamento dell\'università.';
                $messaggioTipo = 'danger';
            }
        }
    } elseif ($action === 'update_candidatura') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $stato = sanitizeInput($_POST['stato'] ?? '');
        $note = sanitizeInput($_POST['note'] ?? '');

        if ($id === 0 || empty($stato)) {
            $messaggio = 'Seleziona uno stato valido per la candidatura.';
            $messaggioTipo = 'danger';
        } else {
            if ($dbh->aggiornaCandidatura($id, $stato, $note)) {
                $messaggio = 'Stato candidatura aggiornato.';
                $messaggioTipo = 'success';
            } else {
                $messaggio = 'Errore durante l\'aggiornamento della candidatura.';
                $messaggioTipo = 'danger';
            }
        }
    }
}

$mobilita = $dbh->getMobilitaTutte();
$universita = $dbh->getUniversita();
$utenti = $dbh->getUtenti();
$candidature = $dbh->getCandidature();

$templateParams["titolo"] = "Admin Dashboard - Erasmus Mobility Manager";
$templateParams["nome"] = "template/admin-dashboard.php";
$templateParams["messaggio"] = $messaggio;
$templateParams["messaggioTipo"] = $messaggioTipo;
$templateParams["mobilita"] = $mobilita;
$templateParams["universita"] = $universita;
$templateParams["utenti"] = $utenti;
$templateParams["candidature"] = $candidature;

require 'template/base-erasmus.php';
?>