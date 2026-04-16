<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }        
    }

    public function getRandomPosts($n){
        $stmt = $this->db->prepare("SELECT idarticolo, titoloarticolo, imgarticolo FROM articolo ORDER BY RAND() LIMIT ?");
        $stmt->bind_param('i',$n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategories(){
        $stmt = $this->db->prepare("SELECT * FROM categoria");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategoryById($idcategory){
        $stmt = $this->db->prepare("SELECT nomecategoria FROM categoria WHERE idcategoria=?");
        $stmt->bind_param('i',$idcategory);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPosts($n=-1){
        $query = "SELECT idarticolo, titoloarticolo, imgarticolo, anteprimaarticolo, dataarticolo, nome FROM articolo, autore WHERE autore=idautore ORDER BY dataarticolo DESC";
        if($n > 0){
            $query .= " LIMIT ?";
        }
        $stmt = $this->db->prepare($query);
        if($n > 0){
            $stmt->bind_param('i',$n);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostById($id){
        $query = "SELECT idarticolo, titoloarticolo, imgarticolo, testoarticolo, dataarticolo, nome FROM articolo, autore WHERE idarticolo=? AND autore=idautore";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostByCategory($idcategory){
        $query = "SELECT idarticolo, titoloarticolo, imgarticolo, anteprimaarticolo, dataarticolo, nome FROM articolo, autore, articolo_ha_categoria WHERE categoria=? AND autore=idautore AND idarticolo=articolo";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$idcategory);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostByIdAndAuthor($id, $idauthor){
        $query = "SELECT idarticolo, anteprimaarticolo, titoloarticolo, imgarticolo, testoarticolo, dataarticolo, (SELECT GROUP_CONCAT(categoria) FROM articolo_ha_categoria WHERE articolo=idarticolo GROUP BY articolo) as categorie FROM articolo WHERE idarticolo=? AND autore=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii',$id, $idauthor);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostByAuthorId($id){
        $query = "SELECT idarticolo, titoloarticolo, imgarticolo FROM articolo WHERE autore=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertArticle($titoloarticolo, $testoarticolo, $anteprimaarticolo, $dataarticolo, $imgarticolo, $autore){
        $query = "INSERT INTO articolo (titoloarticolo, testoarticolo, anteprimaarticolo, dataarticolo, imgarticolo, autore) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssssi',$titoloarticolo, $testoarticolo, $anteprimaarticolo, $dataarticolo, $imgarticolo, $autore);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    public function updateArticleOfAuthor($idarticolo, $titoloarticolo, $testoarticolo, $anteprimaarticolo, $imgarticolo, $autore){
        $query = "UPDATE articolo SET titoloarticolo = ?, testoarticolo = ?, anteprimaarticolo = ?, imgarticolo = ? WHERE idarticolo = ? AND autore = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssii',$titoloarticolo, $testoarticolo, $anteprimaarticolo, $imgarticolo, $idarticolo, $autore);
        
        return $stmt->execute();
    }

    public function deleteArticleOfAuthor($idarticolo, $autore){
        $query = "DELETE FROM articolo WHERE idarticolo = ? AND autore = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii',$idarticolo, $autore);
        $stmt->execute();
        var_dump($stmt->error);
        return true;
    }

    public function insertCategoryOfArticle($articolo, $categoria){
        $query = "INSERT INTO articolo_ha_categoria (articolo, categoria) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii',$articolo, $categoria);
        return $stmt->execute();
    }

    public function deleteCategoryOfArticle($articolo, $categoria){
        $query = "DELETE FROM articolo_ha_categoria WHERE articolo = ? AND categoria = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii',$articolo, $categoria);
        return $stmt->execute();
    }

    public function deleteCategoriesOfArticle($articolo){
        $query = "DELETE FROM articolo_ha_categoria WHERE articolo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$articolo);
        return $stmt->execute();
    }

    public function getAuthors(){
        $query = "SELECT username, nome, GROUP_CONCAT(DISTINCT nomecategoria) as argomenti FROM categoria, articolo, autore, articolo_ha_categoria WHERE idarticolo=articolo AND categoria=idcategoria AND autore=idautore AND attivo=1 GROUP BY username, nome";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function checkLogin($username, $password){
        $query = "SELECT idautore, username, nome FROM autore WHERE attivo=1 AND username = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss',$username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ===== METODI PER NUOVO SCHEMA ERASMUS =====

    // UTENTI
    public function checkLoginErasmus($email, $password){
        $query = "SELECT id_utente, nome, cognome, email, ruolo, tipo_utente FROM utenti WHERE attivo=1 AND email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function registraUtenteErasmus($nome, $cognome, $email, $password, $tipo_utente){
        $query = "INSERT INTO utenti (nome, cognome, email, password, tipo_utente, ruolo) VALUES (?, ?, ?, ?, ?, 'utente')";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssss', $nome, $cognome, $email, $password, $tipo_utente);
        return $stmt->execute();
    }

    public function getUtenteById($id_utente){
        $query = "SELECT id_utente, nome, cognome, email, ruolo, tipo_utente, universita, data_registrazione FROM utenti WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function aggiornaUtente($id_utente, $nome, $cognome, $universita){
        $query = "UPDATE utenti SET nome = ?, cognome = ?, universita = ? WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssi', $nome, $cognome, $universita, $id_utente);
        return $stmt->execute();
    }

    // UNIVERSITÀ
    public function getUniversita(){
        $query = "SELECT id_universita, nome, paese, citta, descrizione, email_contatto FROM universita WHERE attiva = 1 ORDER BY paese, nome";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUniversitaById($id_universita){
        $query = "SELECT * FROM universita WHERE id_universita = ? AND attiva = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_universita);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function inserisciUniversita($nome, $paese, $citta, $descrizione, $sito_web, $email){
        $query = "INSERT INTO universita (nome, paese, citta, descrizione, sito_web, email_contatto, attiva) VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssss', $nome, $paese, $citta, $descrizione, $sito_web, $email);
        return $stmt->execute();
    }

    // MOBILITÀ
    public function getMobilita(){
        $query = "SELECT m.id_mobilita, m.titolo, m.descrizione, m.tipo_mobilita, m.durata_mesi, m.data_inizio, m.data_fine, m.posti_disponibili, m.posti_prenotati, 
                         u.id_universita, u.nome as universita_nome, u.paese, u.citta 
                  FROM mobilita m 
                  JOIN universita u ON m.id_universita_destinazione = u.id_universita 
                  WHERE m.attiva = 1 
                  ORDER BY m.data_inizio DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMobilitaById($id_mobilita){
        $query = "SELECT m.*, u.nome as universita_nome, u.paese, u.citta, u.email_contatto 
                  FROM mobilita m 
                  JOIN universita u ON m.id_universita_destinazione = u.id_universita 
                  WHERE m.id_mobilita = ? AND m.attiva = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_mobilita);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMobilitaByTipo($tipo){
        $query = "SELECT m.id_mobilita, m.titolo, m.descrizione, m.tipo_mobilita, m.durata_mesi, m.data_inizio, m.data_fine, m.posti_disponibili, m.posti_prenotati,
                         u.nome as universita_nome, u.paese, u.citta
                  FROM mobilita m 
                  JOIN universita u ON m.id_universita_destinazione = u.id_universita 
                  WHERE m.attiva = 1 AND (m.tipo_mobilita = ? OR m.tipo_mobilita = 'entrambi')
                  ORDER BY m.data_inizio DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $tipo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function inserisciMobilita($titolo, $descrizione, $id_universita, $tipo, $durata, $data_inizio, $data_fine, $posti, $requisiti, $lingue){
        $query = "INSERT INTO mobilita (titolo, descrizione, id_universita_destinazione, tipo_mobilita, durata_mesi, data_inizio, data_fine, posti_disponibili, requisiti, lingue_richieste, attiva) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssisssiss', $titolo, $descrizione, $id_universita, $tipo, $durata, $data_inizio, $data_fine, $posti, $requisiti, $lingue);
        return $stmt->execute();
    }

    public function aggiornaMobilita($id_mobilita, $titolo, $descrizione, $posti, $data_inizio, $data_fine, $attiva){
        $query = "UPDATE mobilita SET titolo = ?, descrizione = ?, posti_disponibili = ?, data_inizio = ?, data_fine = ?, attiva = ? WHERE id_mobilita = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssisibi', $titolo, $descrizione, $posti, $data_inizio, $data_fine, $attiva, $id_mobilita);
        return $stmt->execute();
    }

    // CANDIDATURE
    public function inserisciCandidatura($id_utente, $id_mobilita){
        $query = "INSERT INTO candidature (id_utente, id_mobilita, stato) VALUES (?, ?, 'in_attesa')";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_utente, $id_mobilita);
        if($stmt->execute()){
            // Aggiorna posti prenotati
            $this->aggiornaPostiMobilita($id_mobilita, 1);
            return true;
        }
        return false;
    }

    public function getCandidatureUtente($id_utente){
        $query = "SELECT c.id_candidatura, c.data_candidatura, c.stato, c.note,
                         m.id_mobilita, m.titolo as mobilita_titolo, m.data_inizio, m.data_fine,
                         u.nome as universita_nome, u.paese
                  FROM candidature c 
                  JOIN mobilita m ON c.id_mobilita = m.id_mobilita 
                  JOIN universita u ON m.id_universita_destinazione = u.id_universita 
                  WHERE c.id_utente = ? 
                  ORDER BY c.data_candidatura DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCandidatureMobilita($id_mobilita){
        $query = "SELECT c.id_candidatura, c.id_utente, c.data_candidatura, c.stato, c.note,
                         u.nome, u.cognome, u.email, u.tipo_utente
                  FROM candidature c 
                  JOIN utenti u ON c.id_utente = u.id_utente 
                  WHERE c.id_mobilita = ? 
                  ORDER BY c.data_candidatura DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_mobilita);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function aggiornaCandidatura($id_candidatura, $stato, $note){
        $query = "UPDATE candidature SET stato = ?, note = ?, data_risposta = NOW() WHERE id_candidatura = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssi', $stato, $note, $id_candidatura);
        return $stmt->execute();
    }

    public function cancellaCandidatura($id_candidatura){
        $query = "DELETE FROM candidature WHERE id_candidatura = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_candidatura);
        return $stmt->execute();
    }

    // HELPER
    private function aggiornaPostiMobilita($id_mobilita, $incremento){
        $query = "UPDATE mobilita SET posti_prenotati = posti_prenotati + ? WHERE id_mobilita = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $incremento, $id_mobilita);
        return $stmt->execute();
    }

}
?>