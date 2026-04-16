<?php
require_once 'bootstrap.php';

$result = array(
    "success" => false,
    "mobilita" => array(),
    "errore" => ""
);

// GET - Recupera mobilità
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = isset($_GET['action']) ? sanitizeInput($_GET['action']) : '';

    // Recupera mobilità recenti/in evidenza
    if ($action === 'getRecenti') {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 3;
        try {
            $result["mobilita"] = $dbh->getMobilita();
            // Limita ai recenti
            $result["mobilita"] = array_slice($result["mobilita"], 0, $limit);
            $result["success"] = true;
        } catch (Exception $e) {
            $result["errore"] = "Errore nel recupero delle mobilità";
        }
    }

    // Recupera tutte le mobilità (per l'archivio)
    else if ($action === 'getAll') {
        try {
            $result["mobilita"] = $dbh->getMobilita();
            $result["success"] = true;
        } catch (Exception $e) {
            $result["errore"] = "Errore nel recupero delle mobilità";
        }
    }

    // Recupera mobilità per tipo (studente, professore)
    else if ($action === 'getByTipo') {
        $tipo = isset($_GET['tipo']) ? sanitizeInput($_GET['tipo']) : '';
        if (!$tipo) {
            $result["errore"] = "Tipo non specificato";
        } else {
            try {
                $result["mobilita"] = $dbh->getMobilitaByTipo($tipo);
                $result["success"] = true;
            } catch (Exception $e) {
                $result["errore"] = "Errore nel recupero delle mobilità";
            }
        }
    }

    // Recupera dettagli di una singola mobilità
    else if ($action === 'getById') {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!$id) {
            $result["errore"] = "ID mobilità non valido";
        } else {
            try {
                $mobilita = $dbh->getMobilitaById($id);
                if (!empty($mobilita)) {
                    $result["mobilita"] = $mobilita[0];
                    $result["success"] = true;
                } else {
                    $result["errore"] = "Mobilità non trovata";
                }
            } catch (Exception $e) {
                $result["errore"] = "Errore nel recupero della mobilità";
            }
        }
    }
}

// POST - Crea, aggiorna, elimina mobilità
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica che l'utente sia admin
    if (!isAdmin()) {
        $result["errore"] = "Non autorizzato";
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }

    $action = isset($_POST['action']) ? sanitizeInput($_POST['action']) : '';

    // Crea nuova mobilità
    if ($action === 'create') {
        $required = array('titolo', 'descrizione', 'id_universita', 'tipo', 'durata', 'data_inizio', 'data_fine', 'posti');
        foreach ($required as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                $result["errore"] = "Campo obbligatorio mancante: $field";
                http_response_code(400);
                break;
            }
        }

        if (empty($result["errore"])) {
            $titolo = sanitizeInput($_POST['titolo']);
            $descrizione = sanitizeInput($_POST['descrizione']);
            $id_universita = (int)$_POST['id_universita'];
            $tipo = sanitizeInput($_POST['tipo']);
            $durata = (int)$_POST['durata'];
            $data_inizio = sanitizeInput($_POST['data_inizio']);
            $data_fine = sanitizeInput($_POST['data_fine']);
            $posti = (int)$_POST['posti'];
            $requisiti = isset($_POST['requisiti']) ? sanitizeInput($_POST['requisiti']) : '';
            $lingue = isset($_POST['lingue']) ? sanitizeInput($_POST['lingue']) : '';

            try {
                if ($dbh->inserisciMobilita($titolo, $descrizione, $id_universita, $tipo, $durata, $data_inizio, $data_fine, $posti, $requisiti, $lingue)) {
                    $result["success"] = true;
                    $result["messaggio"] = "Mobilità creata con successo";
                } else {
                    $result["errore"] = "Errore nella creazione della mobilità";
                }
            } catch (Exception $e) {
                $result["errore"] = "Errore nel sistema: " . $e->getMessage();
            }
        }
    }

    // Aggiorna mobilità
    else if ($action === 'update') {
        $required = array('id', 'titolo', 'descrizione', 'posti', 'data_inizio', 'data_fine', 'attiva');
        foreach ($required as $field) {
            if (!isset($_POST[$field])) {
                $result["errore"] = "Campo obbligatorio mancante: $field";
                http_response_code(400);
                break;
            }
        }

        if (empty($result["errore"])) {
            $id = (int)$_POST['id'];
            $titolo = sanitizeInput($_POST['titolo']);
            $descrizione = sanitizeInput($_POST['descrizione']);
            $posti = (int)$_POST['posti'];
            $data_inizio = sanitizeInput($_POST['data_inizio']);
            $data_fine = sanitizeInput($_POST['data_fine']);
            $attiva = (int)$_POST['attiva'];

            try {
                if ($dbh->aggiornaMobilita($id, $titolo, $descrizione, $posti, $data_inizio, $data_fine, $attiva)) {
                    $result["success"] = true;
                    $result["messaggio"] = "Mobilità aggiornata con successo";
                } else {
                    $result["errore"] = "Errore nell'aggiornamento della mobilità";
                }
            } catch (Exception $e) {
                $result["errore"] = "Errore nel sistema: " . $e->getMessage();
            }
        }
    }

    // Candidatura a una mobilità
    else if ($action === 'candidatura') {
        if (!isUserLoggedInErasmus()) {
            $result["errore"] = "Devi essere loggato per candidarti";
            http_response_code(401);
        } else {
            $id_mobilita = isset($_POST['id_mobilita']) ? (int)$_POST['id_mobilita'] : 0;
            if (!$id_mobilita) {
                $result["errore"] = "ID mobilità non valido";
                http_response_code(400);
            } else {
                try {
                    $id_utente = $_SESSION['id_utente'];
                    if ($dbh->inserisciCandidatura($id_utente, $id_mobilita)) {
                        $result["success"] = true;
                        $result["messaggio"] = "Candidatura inviata con successo!";
                    } else {
                        $result["errore"] = "Hai già una candidatura per questa mobilità o errore nel sistema";
                    }
                } catch (Exception $e) {
                    $result["errore"] = "Errore nel sistema: " . $e->getMessage();
                }
            }
        }
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result);
?>
