<div class="container">
    <!-- Hero Section -->
    <section class="hero-section mb-5 py-5 bg-gradient text-white rounded">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-globe"></i> Erasmus Mobility Manager
                </h1>
                <p class="lead mb-4">
                    Scopri le opportunità di mobilità internazionale presso le nostre università partner. 
                    Partecipa a programmi di scambio, arricchisci la tua esperienza accademica e internazionalizza il tuo percorso formativo.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <?php if(isUserLoggedInErasmus()): ?>
                        <a href="archivio-mobilita.php" class="btn btn-light btn-lg">
                            <i class="fas fa-search"></i> Cerca Mobilità
                        </a>
                        <a href="dashboard.php" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-user"></i> La Mia Dashboard
                        </a>
                    <?php else: ?>
                        <a href="login-erasmus.php" class="btn btn-light btn-lg">
                            <i class="fas fa-sign-in-alt"></i> Accedi
                        </a>
                        <a href="login-erasmus.php" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-user-plus"></i> Registrati
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12 col-md-4 text-center d-none d-md-block">
                <div class="display-1">
                    <i class="fas fa-graduation-cap text-warning"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Cards -->
    <section class="info-section mb-5">
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 border-0 text-center">
                    <div class="card-body">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-university"></i>
                        </div>
                        <h3 class="card-title">Università Partner</h3>
                        <p class="card-text text-muted">
                            Accedi a una rete di università internazionali di eccellenza in tutta Europa.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 border-0 text-center">
                    <div class="card-body">
                        <div class="display-4 text-success mb-3">
                            <i class="fas fa-backpack"></i>
                        </div>
                        <h3 class="card-title">Opportunità Formative</h3>
                        <p class="card-text text-muted">
                            Studi, ricerca, tirocini e insegnamento presso università selezionate.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 border-0 text-center">
                    <div class="card-body">
                        <div class="display-4 text-info mb-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="card-title">Comunità Globale</h3>
                        <p class="card-text text-muted">
                            Connettiti con studenti e docenti da tutto il mondo.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 border-0 text-center">
                    <div class="card-body">
                        <div class="display-4 text-warning mb-3">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h3 class="card-title">Riconoscimento Academico</h3>
                        <p class="card-text text-muted">
                            I crediti acquisiti sono riconosciuti in tutte le università partner.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobilità In Evidenza -->
    <section class="featured-mobility mb-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="display-6 fw-bold">
                    <i class="fas fa-star"></i> Mobilità Consigliate
                </h2>
                <p class="lead text-muted">
                    Scopri le opportunità più interessanti del momento
                </p>
            </div>
        </div>

        <div id="mobilityContainer" class="row g-4">
            <!-- Le mobilità saranno caricate via JavaScript -->
            <div class="col-12 text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Caricamento...</span>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="archivio-mobilita.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-list"></i> Visualizza tutte le mobilità
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works mb-5 py-5 bg-light rounded">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="display-6 fw-bold text-center">
                        <i class="fas fa-question-circle"></i> Come Funziona?
                    </h2>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h4 class="mt-3 fw-bold">1. Registrati</h4>
                        <p class="text-muted">
                            Crea il tuo account indicando i tuoi dati e il tuo ruolo (Studente o Professore).
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-search"></i>
                        </div>
                        <h4 class="mt-3 fw-bold">2. Cerca</h4>
                        <p class="text-muted">
                            Esplora le opportunità disponibili presso le università partner in base ai tuoi interessi.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="rounded-circle bg-info text-white d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h4 class="mt-3 fw-bold">3. Candidati</h4>
                        <p class="text-muted">
                            Invia la tua candidatura per le mobilità che ti interessano. Il nostro team valuterà la richiesta.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="rounded-circle bg-warning text-white d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h4 class="mt-3 fw-bold">4. Parti!</h4>
                        <p class="text-muted">
                            Una volta approvata la tua candidatura, potrai vivere la tua esperienza Erasmus!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section mb-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="display-6 fw-bold">
                    <i class="fas fa-question"></i> Domande Frequenti
                </h2>
            </div>
        </div>

        <div class="accordion" id="faqAccordion" role="region" aria-label="Domande frequenti">
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                        <i class="fas fa-chevron-right me-2"></i> Chi può partecipare ai programmi Erasmus?
                    </button>
                </h3>
                <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" 
                     data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Possono partecipare studenti e docenti regolarmente iscritti presso università partner del programma Erasmus. 
                        Gli studenti devono aver completato almeno il primo anno di studi.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                        <i class="fas fa-chevron-right me-2"></i> Quanto dura un programma di mobilità?
                    </button>
                </h3>
                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" 
                     data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        La durata varia da 2 a 12 mesi a seconda del tipo di mobilità. 
                        Consulta i dettagli di ogni opportunità per la durata specifica.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                        <i class="fas fa-chevron-right me-2"></i> Come vengono riconosciuti i crediti acquisiti?
                    </button>
                </h3>
                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" 
                     data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        I crediti acquisiti presso le università partner sono automaticamente riconosciuti 
                        in base agli accordi Erasmus stipulati tra le istituzioni.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                        <i class="fas fa-chevron-right me-2"></i> È prevista una borsa di studio?
                    </button>
                </h3>
                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" 
                     data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Sì, il programma Erasmus prevede una borsa di studio per coprire i costi di vitto, alloggio 
                        e trasporto. L'importo varia in base al paese di destinazione.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5 bg-primary text-white rounded mb-5">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-3">
                <i class="fas fa-rocket"></i> Pronto a Iniziare la Tua Avventura Erasmus?
            </h2>
            <p class="lead mb-4">
                Scopri le opportunità di mobilità internazionale e trasforma il tuo percorso accademico!
            </p>
            <?php if(!isUserLoggedInErasmus()): ?>
                <a href="login-erasmus.php" class="btn btn-light btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Accedi o Registrati Ora
                </a>
            <?php else: ?>
                <a href="archivio-mobilita.php" class="btn btn-light btn-lg">
                    <i class="fas fa-search"></i> Cerca Mobilità
                </a>
            <?php endif; ?>
        </div>
    </section>
</div>

<style>
    .hero-section {
        background: linear-gradient(135deg, #0d47a1 0%, #1976d2 100%);
    }

    .bg-gradient {
        background: linear-gradient(135deg, #0d47a1 0%, #1976d2 100%);
    }

    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2rem;
        }

        .display-6 {
            font-size: 1.8rem;
        }
    }
</style>
