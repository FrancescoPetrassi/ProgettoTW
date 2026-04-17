<?php
$utente = $templateParams["utente"] ?? array();
$candidature = $templateParams["candidature"] ?? array();
$totaleCandidature = $templateParams["totaleCandidature"] ?? 0;
$inAttesa = $templateParams["inAttesa"] ?? 0;
$approvate = $templateParams["approvate"] ?? 0;
$rifiutate = $templateParams["rifiutate"] ?? 0;

function formatItalianDate($dateString) {
    $date = date_create($dateString);
    return $date ? date_format($date, 'd/m/Y') : '-';
}
?>

<section class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                    <div>
                        <h1 class="h3 mb-2">Ciao <?php echo htmlspecialchars($utente['nome'] . ' ' . $utente['cognome']); ?>!</h1>
                        <p class="text-muted mb-0">Benvenuto nel tuo spazio personale. Qui puoi controllare le candidature inviate e aggiornare i tuoi dati.</p>
                    </div>
                    <a href="profilo.php" class="btn btn-outline-primary align-self-center">Modifica profilo</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-4 g-3 mb-4">
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h5">Candidature totali</h2>
                    <p class="display-6 mb-0"><?php echo $totaleCandidature; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h5">In attesa</h2>
                    <p class="display-6 text-warning mb-0"><?php echo $inAttesa; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h5">Approvate</h2>
                    <p class="display-6 text-success mb-0"><?php echo $approvate; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h5">Rifiutate</h2>
                    <p class="display-6 text-danger mb-0"><?php echo $rifiutate; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h5 mb-1">Le tue candidature</h2>
                        <p class="text-muted mb-0">Visualizza lo stato e le informazioni delle tue candidature presentate.</p>
                    </div>
                    <a href="archivio-mobilita.php" class="btn btn-primary">Esplora nuove mobilità</a>
                </div>

                <?php if (empty($candidature)): ?>
                    <div class="alert alert-info mb-0" role="alert">
                        Non hai ancora inviato candidature. Vai all'archivio per trovare la mobilità giusta per te.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Mobilità</th>
                                    <th>Università</th>
                                    <th>Periodo</th>
                                    <th>Data candidatura</th>
                                    <th>Stato</th>
                                    <th class="text-end">Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($candidature as $candidatura): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($candidatura['mobilita_titolo']); ?></td>
                                        <td><?php echo htmlspecialchars($candidatura['universita_nome'] . ' (' . $candidatura['paese'] . ')'); ?></td>
                                        <td><?php echo formatItalianDate($candidatura['data_inizio']) . ' - ' . formatItalianDate($candidatura['data_fine']); ?></td>
                                        <td><?php echo formatItalianDate($candidatura['data_candidatura']); ?></td>
                                        <td>
                                            <?php
                                            $badgeClass = 'secondary';
                                            switch ($candidatura['stato']) {
                                                case 'approvato':
                                                    $badgeClass = 'success';
                                                    break;
                                                case 'rifiutato':
                                                    $badgeClass = 'danger';
                                                    break;
                                                case 'in_attesa':
                                                default:
                                                    $badgeClass = 'warning';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge bg-<?php echo $badgeClass; ?> text-dark text-uppercase small"><?php echo str_replace('_', ' ', $candidatura['stato']); ?></span>
                                        </td>
                                        <td class="text-end"><?php echo htmlspecialchars($candidatura['note'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
