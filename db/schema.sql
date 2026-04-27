-- Schema Database Erasmus Mobility Manager
-- Progetto Tecnologie Web - Mobilità Internazionale tra Università Partner

-- Tabella Utenti
CREATE TABLE IF NOT EXISTS utenti (
    id_utente INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    ruolo ENUM('admin', 'utente') DEFAULT 'utente',
    tipo_utente ENUM('studente', 'professore') NULL,
    universita VARCHAR(100),
    data_registrazione DATETIME DEFAULT CURRENT_TIMESTAMP,
    attivo BOOLEAN DEFAULT TRUE
);

-- Tabella Università Partner
CREATE TABLE IF NOT EXISTS universita (
    id_universita INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    paese VARCHAR(100) NOT NULL,
    citta VARCHAR(100),
    descrizione TEXT,
    sito_web VARCHAR(255),
    email_contatto VARCHAR(100),
    data_creazione DATETIME DEFAULT CURRENT_TIMESTAMP,
    attiva BOOLEAN DEFAULT TRUE
);

-- Tabella Opportunità di Mobilità
CREATE TABLE IF NOT EXISTS mobilita (
    id_mobilita INT PRIMARY KEY AUTO_INCREMENT,
    titolo VARCHAR(150) NOT NULL,
    descrizione TEXT NOT NULL,
    id_universita_destinazione INT NOT NULL,
    tipo_mobilita ENUM('studente', 'professore', 'entrambi') DEFAULT 'entrambi',
    durata_mesi INT,
    data_inizio DATE NOT NULL,
    data_fine DATE NOT NULL,
    posti_disponibili INT,
    posti_prenotati INT DEFAULT 0,
    requisiti TEXT,
    lingue_richieste VARCHAR(255),
    data_creazione DATETIME DEFAULT CURRENT_TIMESTAMP,
    attiva BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id_universita_destinazione) REFERENCES universita(id_universita)
);

-- Tabella Candidature
CREATE TABLE IF NOT EXISTS candidature (
    id_candidatura INT PRIMARY KEY AUTO_INCREMENT,
    id_utente INT NOT NULL,
    id_mobilita INT NOT NULL,
    data_candidatura DATETIME DEFAULT CURRENT_TIMESTAMP,
    stato ENUM('in_attesa', 'approvata', 'rifiutata', 'ritirata') DEFAULT 'in_attesa',
    note TEXT,
    data_risposta DATETIME NULL,
    data_ultimo_aggiornamento DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utente) REFERENCES utenti(id_utente),
    FOREIGN KEY (id_mobilita) REFERENCES mobilita(id_mobilita),
    UNIQUE KEY unique_candidatura (id_utente, id_mobilita)
);

-- Inserimento dati di test
-- Utente Admin
INSERT INTO utenti (nome, cognome, email, password, ruolo, attivo) 
VALUES ('Admin', 'Sistema', 'admin@erasmus.it', MD5('admin123'), 'admin', TRUE);

-- Università Partner (esempi)
INSERT INTO universita (nome, paese, citta, descrizione, sito_web, email_contatto, attiva) 
VALUES 
('Universidad de Barcelona', 'Spagna', 'Barcellona', 'Universita leader in Catalogna', 'www.ub.edu', 'mobility@ub.edu', TRUE),
('Universitat Berlin', 'Germania', 'Berlino', 'Universita storica di Berlino', 'www.hu-berlin.de', 'erasmus@hu-berlin.de', TRUE),
('Universite de Lyon', 'Francia', 'Lione', 'Universita principale della regione Rodano-Alpi', 'www.univ-lyon.fr', 'international@univ-lyon.fr', TRUE),
('Universidade de Lisboa', 'Portogallo', 'Lisbona', 'Universita prestigiosa portoghese', 'www.ulisboa.pt', 'erasmus@ulisboa.pt', TRUE);

-- Opportunità di Mobilità (esempi)
INSERT INTO mobilita (titolo, descrizione, id_universita_destinazione, tipo_mobilita, durata_mesi, data_inizio, data_fine, posti_disponibili, requisiti, lingue_richieste, attiva)
VALUES
('Scambio Studenti - Barcelona', 'Opportunità di studio presso l''Università di Barcelona per studenti iscritti a corsi di Ingegneria e Scienze', 1, 'studente', 6, '2024-09-01', '2025-02-28', 10, 'Media >= 28/30, Diploma di Scuola Superiore', 'Spagnolo, Inglese', TRUE),
('Visiting Scholar - Berlin', 'Programma di ricerca per docenti presso Università di Berlino nel settore STEM', 2, 'professore', 3, '2024-10-01', '2024-12-31', 5, 'Dottorato di Ricerca, Esperienza di ricerca provata', 'Tedesco, Inglese', TRUE),
('Internship - Lyon', 'Stage pratico presso aziende partner di Lione per studenti di Ingegneria', 3, 'studente', 4, '2024-11-15', '2025-03-15', 8, 'Iscrizione corso Ingegneria, Francese base', 'Francese, Inglese', TRUE),
('Faculty Exchange - Lisboa', 'Scambio docenti per insegnamento e ricerca collaborativa', 4, 'professore', 2, '2024-12-01', '2025-01-31', 3, 'Docente universitario, Pubblicazioni recenti', 'Portoghese, Inglese', TRUE);
