<?php
$utente = $templateParams["utente"] ?? array();
$profiloMsg = $templateParams["profiloMsg"] ?? '';
$profiloMsgType = $templateParams["profiloMsgType"] ?? 'success';
?>

<section class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                    <div>
                        <h1 class="h3 mb-2">Il tuo profilo</h1>
                        <p class="text-muted mb-0">Aggiorna le informazioni che vuoi rendere visibili al team Erasmus.</p>
                    </div>
                    <a href="dashboard.php" class="btn btn-outline-secondary align-self-center">Torna alla dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($profiloMsg)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-<?php echo htmlspecialchars($profiloMsgType); ?>" role="alert">
                    <?php echo htmlspecialchars($profiloMsg); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required value="<?php echo htmlspecialchars($utente['nome'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="cognome" class="form-label">Cognome</label>
                        <input type="text" class="form-control" id="cognome" name="cognome" required value="<?php echo htmlspecialchars($utente['cognome'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($utente['email'] ?? ''); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="universita" class="form-label">Università di provenienza</label>
                        <input type="text" class="form-control" id="universita" name="universita" value="<?php echo htmlspecialchars($utente['universita'] ?? ''); ?>" placeholder="Inserisci la tua università">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ruolo</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($utente['ruolo'] ?? 'Utente'); ?>" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Salva modifiche</button>
                </form>
            </div>
        </div>
    </div>
</section>
