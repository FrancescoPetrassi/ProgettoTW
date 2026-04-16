<?php
require_once 'bootstrap.php';

$result = array(
    "logineseguito" => false,
    "errore" => "",
    "tipo" => "login" // Per distinguere login da registrazione
);

// LOGIN
if(isset($_POST["action"]) && $_POST["action"] === "login"){
    if(!isset($_POST["email"]) || !isset($_POST["password"])){
        $result["errore"] = "Email e password sono obbligatori";
    } else {
        $email = sanitizeInput($_POST["email"]);
        $password = $_POST["password"];
        
        // Query per verificare l'utente
        $login_result = $dbh->checkLoginErasmus($email, $password);
        
        if(count($login_result) == 0){
            $result["errore"] = "Email e/o password errati";
        } else {
            $user = $login_result[0];
            registerLoggedUserErasmus($user);
            $result["logineseguito"] = true;
            $result["ruolo"] = $user["ruolo"];
            $result["redirect"] = $user["ruolo"] === "admin" ? "admin-dashboard.php" : "dashboard.php";
        }
    }
}

// REGISTRAZIONE
if(isset($_POST["action"]) && $_POST["action"] === "registrazione"){
    $result["tipo"] = "registrazione";
    
    if(!isset($_POST["nome"]) || !isset($_POST["cognome"]) || !isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["tipo_utente"])){
        $result["errore"] = "Tutti i campi sono obbligatori";
    } else {
        $nome = sanitizeInput($_POST["nome"]);
        $cognome = sanitizeInput($_POST["cognome"]);
        $email = sanitizeInput($_POST["email"]);
        $password = $_POST["password"];
        $tipo_utente = sanitizeInput($_POST["tipo_utente"]);
        
        if(!validateEmail($email)){
            $result["errore"] = "Email non valida";
        } else if(strlen($password) < 8){
            $result["errore"] = "La password deve avere almeno 8 caratteri";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            if($dbh->registraUtenteErasmus($nome, $cognome, $email, $password_hash, $tipo_utente)){
                $result["logineseguito"] = true;
                $result["messaggio"] = "Registrazione completata! Effettua il login.";
            } else {
                $result["errore"] = "Email già registrata o errore nel sistema";
            }
        }
    }
}

// LOGOUT
if(isset($_POST["action"]) && $_POST["action"] === "logout"){
    logoutUserErasmus();
    $result["logineseguito"] = false;
    $result["messaggio"] = "Logout effettuato";
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result);
?>
