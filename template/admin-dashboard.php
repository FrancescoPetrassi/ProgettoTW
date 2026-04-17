<?php
$messaggio = $templateParams["messaggio"] ?? '';
$messaggioTipo = $templateParams["messaggioTipo"] ?? 'success';
$mobilita = $templateParams["mobilita"] ?? array();
$universita = $templateParams["universita"] ?? array();
$utenti = $templateParams["utenti"] ?? array();
$candidature = $templateParams["candidature"] ?? array();

function formatItalianDate($dateString) {
    $date = date_create($dateString);
    return $date ? date_format($date, 'd/m/Y') : '-';
}
?>

<section class="container py-4">
    <?php if (!empty($messaggio)): ?>
        <div class="alert alert-<?php echo htmlspecialchars($messaggioTipo); ?>" role="alert">
            <?php echo htmlspecialchars($messaggio); ?>
        </div>
    <?php endif; ?>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h6 text-uppercase text-muted">Mobilità</h2>
                    <p class="display-6 mb-0"><?php echo count($mobilita); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h6 text-uppercase text-muted">Università</h2>
                    <p class="display-6 mb-0"><?php echo count($universita); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h6 text-uppercase text-muted">Utenti</h2>
                    <p class="display-6 mb-0"><?php echo count($utenti); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h6 text-uppercase text-muted">Candidature</h2>
                    <p class="display-6 mb-0"><?php echo count($candidature); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="h6 mb-0">Aggiungi nuova mobilità</h3>
                </div>
                <div class="card-body">
                    <form method="POST" novalidate>
                        <input type="hidden" name="action" value="create_mobilita">
                        <div class="mb-3">
                            <label for="titolo" class="form-label">Titolo</label>
                            <input type="text" class="form-control" id="titolo" name="titolo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descrizione" class="form-label">Descrizione</label>
                            <textarea class="form-control" id="descrizione" name="descrizione" rows="3" required></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="id_universita" class="form-label">Università destinazione</label>
                                <select class="form-select" id="id_universita" name="id_universita" required>
                                    <option value="">Seleziona università</option>
                                    <?php foreach ($universita as $uni): ?>
                                        <option value="<?php echo $uni['id_universita']; ?>"><?php echo htmlspecialchars($uni['nome'] . ' - ' . $uni['paese']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="tipo" class="form-label">Tipo mobilità</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="">Scegli tipo</option>
                                    <option value="studente">Studente</option>
                                    <option value="professore">Professore</option>
                                    <option value="entrambi">Entrambi</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-6">
                                <label for="durata" class="form-label">Durata (mesi)</label>
                                <input type="number" min="1" class="form-control" id="durata" name="durata" required>
                            </div>
                            <div class="col-6">
                                <label for="posti" class="form-label">Posti disponibili</label>
                                <input type="number" min="1" class="form-control" id="posti" name="posti" required>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-6">
                                <label for="data_inizio" class="form-label">Data inizio</label>
                                <input type="date" class="form-control" id="data_inizio" name="data_inizio" required>
                            </div>
                            <div class="col-6">
                                <label for="data_fine" class="form-label">Data fine</label>
                                <input type="date" class="form-control" id="data_fine" name="data_fine" required>
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="requisiti" class="form-label">Requisiti</label>
                            <textarea class="form-control" id="requisiti" name="requisiti" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="lingue" class="form-label">Lingue richieste</label>
                            <input type="text" class="form-control" id="lingue" name="lingue" placeholder="es. Inglese, Francese">
                        </div>
                        <button type="submit" class="btn btn-primary">Crea mobilità</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h3 class="h6 mb-0">Aggiungi nuova università</h3>
                </div>
                <div class="card-body">
                    <form method="POST" novalidate>
                        <input type="hidden" name="action" value="create_universita">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome università</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label for="paese" class="form-label">Paese</label>
                                <input type="text" class="form-control" id="paese" name="paese" required>
                            </div>
                            <div class="col-6">
                                <label for="citta" class="form-label">Città</label>
                                <input type="text" class="form-control" id="citta" name="citta" required>
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="descrizione" class="form-label">Descrizione</label>
                            <textarea class="form-control" id="descrizione" name="descrizione" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sito_web" class="form-label">Sito web</label>
                            <input type="url" class="form-control" id="sito_web" name="sito_web" placeholder="https://">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email contatto</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-secondary">Aggiungi università</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-dark">
                    <h3 class="h6 mb-0">Gestione mobilità</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($mobilita)): ?>
                        <div class="alert alert-light">Non ci sono mobilità disponibili.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Titolo</th>
                                        <th>Università</th>
                                        <th>Tipo</th>
                                        <th>Durata</th>
                                        <th>Posti</th>
                                        <th>Stato</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mobilita as $m): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($m['titolo']); ?></td>
                                            <td><?php echo htmlspecialchars($m['universita_nome']); ?></td>
                                            <td><?php echo htmlspecialchars($m['tipo_mobilita']); ?></td>
                                            <td><?php echo htmlspecialchars($m['durata_mesi']); ?> mesi</td>
                                            <td><?php echo htmlspecialchars($m['posti_disponibili']); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $m['attiva'] ? 'success' : 'secondary'; ?>">
                                                    <?php echo $m['attiva'] ? 'Attiva' : 'Disattiva'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#editMobilita<?php echo $m['id_mobilita']; ?>" aria-expanded="false" aria-controls="editMobilita<?php echo $m['id_mobilita']; ?>">Modifica</button>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="editMobilita<?php echo $m['id_mobilita']; ?>">
                                            <td colspan="7">
                                                <div class="border rounded-3 p-3 bg-light">
                                                    <form method="POST" class="row g-3">
                                                        <input type="hidden" name="action" value="update_mobilita">
                                                        <input type="hidden" name="id" value="<?php echo $m['id_mobilita']; ?>">
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">Titolo</label>
                                                            <input type="text" class="form-control" name="titolo" value="<?php echo htmlspecialchars($m['titolo']); ?>" required>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">Posti disponibili</label>
                                                            <input type="number" min="0" class="form-control" name="posti" value="<?php echo htmlspecialchars($m['posti_disponibili']); ?>" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Descrizione</label>
                                                            <textarea class="form-control" name="descrizione" rows="2" required><?php echo htmlspecialchars($m['descrizione']); ?></textarea>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">Data inizio</label>
                                                            <input type="date" class="form-control" name="data_inizio" value="<?php echo htmlspecialchars($m['data_inizio']); ?>" required>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">Data fine</label>
                                                            <input type="date" class="form-control" name="data_fine" value="<?php echo htmlspecialchars($m['data_fine']); ?>" required>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">Stato attiva</label>
                                                            <select class="form-select" name="attiva">
                                                                <option value="1" <?php echo $m['attiva'] ? 'selected' : ''; ?>>Attiva</option>
                                                                <option value="0" <?php echo !$m['attiva'] ? 'selected' : ''; ?>>Disattiva</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="submit" class="btn btn-primary">Aggiorna mobilità</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="h6 mb-0">Elenco università</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($universita)): ?>
                        <div class="alert alert-light">Nessuna università registrata.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Paese</th>
                                        <th>Città</th>
                                        <th>Email</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($universita as $u): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($u['nome']); ?></td>
                                            <td><?php echo htmlspecialchars($u['paese']); ?></td>
                                            <td><?php echo htmlspecialchars($u['citta']); ?></td>
                                            <td><?php echo htmlspecialchars($u['email_contatto']); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#editUniversita<?php echo $u['id_universita']; ?>" aria-expanded="false" aria-controls="editUniversita<?php echo $u['id_universita']; ?>">Modifica</button>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="editUniversita<?php echo $u['id_universita']; ?>">
                                            <td colspan="5">
                                                <div class="border rounded-3 p-3 bg-light">
                                                    <form method="POST" class="row g-3">
                                                        <input type="hidden" name="action" value="update_universita">
                                                        <input type="hidden" name="id_universita" value="<?php echo $u['id_universita']; ?>">
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">Nome</label>
                                                            <input type="text" class="form-control" name="nome" value="<?php echo htmlspecialchars($u['nome']); ?>" required>
                                                        </div>
                                                        <div class="col-6 col-md-3">
                                                            <label class="form-label">Paese</label>
                                                            <input type="text" class="form-control" name="paese" value="<?php echo htmlspecialchars($u['paese']); ?>" required>
                                                        </div>
                                                        <div class="col-6 col-md-3">
                                                            <label class="form-label">Città</label>
                                                            <input type="text" class="form-control" name="citta" value="<?php echo htmlspecialchars($u['citta']); ?>" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($u['email_contatto']); ?>" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Sito web</label>
                                                            <input type="url" class="form-control" name="sito_web" value="<?php echo htmlspecialchars($u['sito_web']); ?>">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Descrizione</label>
                                                            <textarea class="form-control" name="descrizione" rows="2"><?php echo htmlspecialchars($u['descrizione']); ?></textarea>
                                                        </div>
                                                        <div class="col-12 col-md-4">
                                                            <label class="form-label">Attiva</label>
                                                            <select class="form-select" name="attiva">
                                                                <option value="1" <?php echo $u['attiva'] ? 'selected' : ''; ?>>Sì</option>
                                                                <option value="0" <?php echo !$u['attiva'] ? 'selected' : ''; ?>>No</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="submit" class="btn btn-success">Aggiorna università</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h3 class="h6 mb-0">Elenco utenti</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($utenti)): ?>
                        <div class="alert alert-light">Non ci sono utenti registrati.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Ruolo</th>
                                        <th>Tipo</th>
                                        <th>Università</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($utenti as $u): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($u['nome'] . ' ' . $u['cognome']); ?></td>
                                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                                            <td><?php echo htmlspecialchars($u['ruolo']); ?></td>
                                            <td><?php echo htmlspecialchars($u['tipo_utente']); ?></td>
                                            <td><?php echo htmlspecialchars($u['universita']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h3 class="h6 mb-0">Candidature</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($candidature)): ?>
                        <div class="alert alert-light">Non ci sono candidature al momento.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Candidato</th>
                                        <th>Mobilità</th>
                                        <th>Università</th>
                                        <th>Data candidatura</th>
                                        <th>Stato</th>
                                        <th>Note</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($candidature as $c): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($c['nome_utente'] . ' ' . $c['cognome_utente']); ?></td>
                                            <td><?php echo htmlspecialchars($c['mobilita_titolo']); ?></td>
                                            <td><?php echo htmlspecialchars($c['universita_nome']); ?></td>
                                            <td><?php echo formatItalianDate($c['data_candidatura']); ?></td>
                                            <td><?php echo htmlspecialchars(str_replace('_', ' ', $c['stato'])); ?></td>
                                            <td><?php echo htmlspecialchars($c['note'] ?? '-'); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#editCandidatura<?php echo $c['id_candidatura']; ?>" aria-expanded="false" aria-controls="editCandidatura<?php echo $c['id_candidatura']; ?>">Aggiorna</button>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="editCandidatura<?php echo $c['id_candidatura']; ?>">
                                            <td colspan="7">
                                                <div class="border rounded-3 p-3 bg-light">
                                                    <form method="POST" class="row g-3">
                                                        <input type="hidden" name="action" value="update_candidatura">
                                                        <input type="hidden" name="id" value="<?php echo $c['id_candidatura']; ?>">
                                                        <div class="col-12 col-md-4">
                                                            <label class="form-label">Stato</label>
                                                            <select class="form-select" name="stato" required>
                                                                <option value="in_attesa" <?php echo $c['stato'] === 'in_attesa' ? 'selected' : ''; ?>>In attesa</option>
                                                                <option value="approvato" <?php echo $c['stato'] === 'approvato' ? 'selected' : ''; ?>>Approvato</option>
                                                                <option value="rifiutato" <?php echo $c['stato'] === 'rifiutato' ? 'selected' : ''; ?>>Rifiutato</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">Note</label>
                                                            <input type="text" class="form-control" name="note" value="<?php echo htmlspecialchars($c['note']); ?>">
                                                        </div>
                                                        <div class="col-12 col-md-2 text-end">
                                                            <button type="submit" class="btn btn-dark">Salva</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
