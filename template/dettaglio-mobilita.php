<?php
$mobilita = $templateParams["mobilita"] ?? array();
$messaggio = $templateParams["messaggio"] ?? '';
$messaggioTipo = $templateParams["messaggioTipo"] ?? 'success';
$utenteAlreadyCandidated = $templateParams["utenteAlreadyCandidated"] ?? false;
$isLoggedIn = $templateParams["isLoggedIn"] ?? false;

function formatItalianDate($dateString) {
    $date = date_create($dateString);
    return $date ? date_format($date, 'd/m/Y') : '-';
}

function getDaysUntil($dateString) {
    $date = date_create($dateString);
    $now = date_create('now');
    if (!$date) return null;
    $interval = date_diff($now, $date);
    return $interval->days;
}

$daysUntilStart = getDaysUntil($mobilita['data_inizio'] ?? null);
?>

<section class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <a href="archivio-mobilita.php" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Torna all'archivio
            </a>
        </div>
    </div>

    <?php if (!empty($messaggio)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-<?php echo htmlspecialchars($messaggioTipo); ?>" role="alert">
                    <i class="fas fa-<?php echo $messaggioTipo === 'success' ? 'check-circle' : 'exclamation-circle'; ?> me-2"></i>
                    <?php echo htmlspecialchars($messaggio); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <h1 class="h3 mb-2"><?php echo htmlspecialchars($mobilita['titolo']); ?></h1>
                            <p class="text-muted mb-0">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <?php echo htmlspecialchars($mobilita['universita_nome'] . ' - ' . $mobilita['paese'] . ', ' . $mobilita['citta']); ?>
                            </p>
                        </div>
                        <div>
                            <?php
                            $badgeClass = 'secondary';
                            $badgeText = 'Non disponibile';
                            if ($mobilita['posti_disponibili'] > 0) {
                                if ($mobilita['posti_disponibili'] <= 3) {
                                    $badgeClass = 'danger';
                                    $badgeText = 'Posti limitati';
                                } else {
                                    $badgeClass = 'success';
                                    $badgeText = 'Disponibile';
                                }
                            }
                            ?>
                            <span class="badge bg-<?php echo $badgeClass; ?> p-3 text-uppercase"><?php echo $badgeText; ?></span>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-4">
                        <div class="col">
                            <div class="bg-light rounded-3 p-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-users me-2"></i>Tipo mobilità
                                </p>
                                <p class="h6 mb-0">
                                    <?php
                                    $typeText = '';
                                    switch($mobilita['tipo_mobilita']) {
                                        case 'studente':
                                            $typeText = 'Per studenti';
                                            break;
                                        case 'professore':
                                            $typeText = 'Per docenti';
                                            break;
                                        case 'entrambi':
                                            $typeText = 'Studenti e docenti';
                                            break;
                                    }
                                    echo htmlspecialchars($typeText);
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-light rounded-3 p-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-calendar me-2"></i>Durata
                                </p>
                                <p class="h6 mb-0"><?php echo htmlspecialchars($mobilita['durata_mesi']); ?> mesi</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-light rounded-3 p-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-chair me-2"></i>Posti disponibili
                                </p>
                                <p class="h6 mb-0"><?php echo htmlspecialchars($mobilita['posti_disponibili']); ?> / <?php echo htmlspecialchars($mobilita['posti_disponibili'] + $mobilita['posti_prenotati']); ?></p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-light rounded-3 p-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-hourglass-start me-2"></i>Inizio
                                </p>
                                <p class="h6 mb-0"><?php echo formatItalianDate($mobilita['data_inizio']); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h2 class="h5 mb-3">Descrizione della mobilità</h2>
                        <p><?php echo nl2br(htmlspecialchars($mobilita['descrizione'])); ?></p>
                    </div>

                    <?php if (!empty($mobilita['requisiti'])): ?>
                        <div class="mb-4">
                            <h2 class="h5 mb-3">Requisiti</h2>
                            <ul class="list-unstyled">
                                <?php foreach (explode(',', $mobilita['requisiti']) as $req): ?>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <?php echo htmlspecialchars(trim($req)); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($mobilita['lingue_richieste'])): ?>
                        <div class="mb-4">
                            <h2 class="h5 mb-3">Lingue richieste</h2>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach (explode(',', $mobilita['lingue_richieste']) as $lingua): ?>
                                    <span class="badge bg-info">
                                        <i class="fas fa-language me-1"></i>
                                        <?php echo htmlspecialchars(trim($lingua)); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row g-3 border-top pt-4">
                        <div class="col-12 col-sm-6">
                            <h2 class="h6 text-muted mb-2">Periodo mobilità</h2>
                            <p class="mb-0">
                                <i class="fas fa-calendar-range me-2 text-primary"></i>
                                <?php echo formatItalianDate($mobilita['data_inizio']); ?> - <?php echo formatItalianDate($mobilita['data_fine']); ?>
                            </p>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h2 class="h6 text-muted mb-2">Università partner</h2>
                            <p class="mb-0">
                                <i class="fas fa-university me-2 text-primary"></i>
                                <?php echo htmlspecialchars($mobilita['universita_nome']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0">Candidati a questa mobilità</h2>
                </div>
                <div class="card-body">
                    <?php if (!$isLoggedIn): ?>
                        <div class="alert alert-info mb-3" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            Devi effettuare il login per candidarti.
                        </div>
                        <a href="login-erasmus.php" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Vai al login
                        </a>
                    <?php elseif ($utenteAlreadyCandidated): ?>
                        <div class="alert alert-success mb-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            Hai già una candidatura per questa mobilità.
                        </div>
                        <p class="text-muted small mb-0">
                            Puoi controllare lo stato nella tua <a href="dashboard.php">dashboard personale</a>.
                        </p>
                    <?php elseif ($mobilita['posti_disponibili'] <= 0): ?>
                        <div class="alert alert-warning mb-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Purtroppo non ci sono più posti disponibili per questa mobilità.
                        </div>
                    <?php else: ?>
                        <form method="POST" id="candidaturaForm">
                            <div class="alert alert-light border mb-3">
                                <p class="small mb-0">
                                    <strong><?php echo htmlspecialchars($mobilita['posti_disponibili']); ?> posti disponibili</strong><br>
                                    Candidandoti accetti i termini della mobilità Erasmus.
                                </p>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-paper-plane me-2"></i>Invia candidatura
                            </button>
                            <p class="small text-muted mb-0">
                                Riceverai una conferma via email e potrai tracciare lo stato della tua candidatura dalla dashboard.
                            </p>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-secondary text-white">
                    <h2 class="h5 mb-0">Informazioni università</h2>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        <strong><?php echo htmlspecialchars($mobilita['universita_nome']); ?></strong><br>
                        <?php echo htmlspecialchars($mobilita['citta'] . ', ' . $mobilita['paese']); ?>
                    </p>
                    <div class="mb-3">
                        <p class="small text-muted mb-2">
                            <i class="fas fa-envelope me-2"></i>Email contatto:
                        </p>
                        <p class="mb-0">
                            <a href="mailto:<?php echo htmlspecialchars($mobilita['email_contatto']); ?>">
                                <?php echo htmlspecialchars($mobilita['email_contatto']); ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
