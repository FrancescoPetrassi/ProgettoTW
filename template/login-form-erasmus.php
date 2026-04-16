<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <!-- Tabs per Login e Registrazione -->
            <ul class="nav nav-tabs mb-4" id="authTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-content" type="button" role="tab" aria-controls="login-content" aria-selected="true">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="registro-tab" data-bs-toggle="tab" data-bs-target="#registro-content" type="button" role="tab" aria-controls="registro-content" aria-selected="false">
                        <i class="fas fa-user-plus"></i> Registrazione
                    </button>
                </li>
            </ul>

            <!-- Contenuto Tab -->
            <div class="tab-content" id="authTabContent">
                
                <!-- Tab Login -->
                <div class="tab-pane fade show active" id="login-content" role="tabpanel" aria-labelledby="login-tab">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="card-title mb-4 text-primary">
                                <i class="fas fa-sign-in-alt"></i> Accedi al Sistema
                            </h2>
                            <form id="loginForm" method="POST" novalidate>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger" aria-label="obbligatorio">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required 
                                           aria-describedby="emailHelp" placeholder="tue-mail@universita.it">
                                    <small id="emailHelp" class="form-text text-muted">
                                        Inserisci l'email con cui ti sei registrato
                                    </small>
                                    <div class="invalid-feedback">
                                        Per favore, inserisci un'email valida.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger" aria-label="obbligatorio">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required 
                                               aria-describedby="passwordHelp" placeholder="La tua password">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" 
                                                aria-label="Mostra/nascondi password" title="Mostra/nascondi password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small id="passwordHelp" class="form-text text-muted">
                                        La password deve avere almeno 8 caratteri
                                    </small>
                                    <div class="invalid-feedback">
                                        Per favore, inserisci la password.
                                    </div>
                                </div>

                                <div id="loginAlert" class="alert alert-danger d-none" role="alert"></div>

                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-sign-in-alt"></i> Accedi
                                </button>
                                <button type="button" class="btn btn-secondary w-100" data-bs-toggle="tab" data-bs-target="#registro-content">
                                    Non hai ancora un account? Registrati
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab Registrazione -->
                <div class="tab-pane fade" id="registro-content" role="tabpanel" aria-labelledby="registro-tab">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="card-title mb-4 text-primary">
                                <i class="fas fa-user-plus"></i> Registrati al Sistema
                            </h2>
                            <form id="registrationForm" method="POST" novalidate>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nome" class="form-label">Nome <span class="text-danger" aria-label="obbligatorio">*</span></label>
                                        <input type="text" class="form-control" id="nome" name="nome" required 
                                               placeholder="Mario" minlength="2" maxlength="50">
                                        <div class="invalid-feedback">
                                            Inserisci un nome valido.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cognome" class="form-label">Cognome <span class="text-danger" aria-label="obbligatorio">*</span></label>
                                        <input type="text" class="form-control" id="cognome" name="cognome" required 
                                               placeholder="Rossi" minlength="2" maxlength="50">
                                        <div class="invalid-feedback">
                                            Inserisci un cognome valido.
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="emailReg" class="form-label">Email <span class="text-danger" aria-label="obbligatorio">*</span></label>
                                    <input type="email" class="form-control" id="emailReg" name="email" required 
                                           placeholder="tue-mail@universita.it" aria-describedby="emailRegHelp">
                                    <small id="emailRegHelp" class="form-text text-muted">
                                        Usa l'email della tua università o personale
                                    </small>
                                    <div class="invalid-feedback">
                                        Inserisci un'email valida.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tipoUtente" class="form-label">Chi sei? <span class="text-danger" aria-label="obbligatorio">*</span></label>
                                    <select class="form-select" id="tipoUtente" name="tipo_utente" required 
                                            aria-describedby="tipoUtenteHelp">
                                        <option value="" selected disabled>Seleziona il tuo ruolo</option>
                                        <option value="studente"><i class="fas fa-graduation-cap"></i> Studente</option>
                                        <option value="professore"><i class="fas fa-chalkboard-user"></i> Professore</option>
                                    </select>
                                    <small id="tipoUtenteHelp" class="form-text text-muted">
                                        Seleziona il ruolo che meglio ti rappresenta
                                    </small>
                                    <div class="invalid-feedback">
                                        Per favore, seleziona il tuo ruolo.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="passwordReg" class="form-label">Password <span class="text-danger" aria-label="obbligatorio">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="passwordReg" name="password" required 
                                               aria-describedby="passwordRegHelp" placeholder="Almeno 8 caratteri" minlength="8">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordReg" 
                                                aria-label="Mostra/nascondi password" title="Mostra/nascondi password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small id="passwordRegHelp" class="form-text text-muted d-block">
                                        Deve contenere almeno 8 caratteri
                                    </small>
                                    <div id="passwordStrength" class="mt-2">
                                        <div class="progress" style="height: 5px;">
                                            <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%" 
                                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small id="strengthText" class="text-muted"></small>
                                    </div>
                                    <div class="invalid-feedback">
                                        La password deve avere almeno 8 caratteri.
                                    </div>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="agreeTerms" name="agree_terms" required>
                                    <label class="form-check-label" for="agreeTerms">
                                        Accetto i <a href="#" target="_blank">termini e condizioni</a> <span class="text-danger" aria-label="obbligatorio">*</span>
                                    </label>
                                    <div class="invalid-feedback">
                                        Devi accettare i termini e le condizioni.
                                    </div>
                                </div>

                                <div id="registrationAlert" class="alert alert-danger d-none" role="alert"></div>

                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-user-plus"></i> Registrati
                                </button>
                                <button type="button" class="btn btn-secondary w-100" data-bs-toggle="tab" data-bs-target="#login-content">
                                    Hai già un account? Accedi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="alert alert-info mt-4" role="note">
                <h5 class="alert-heading">
                    <i class="fas fa-info-circle"></i> Informazioni Importanti
                </h5>
                <p class="mb-2">
                    <strong>Per Studenti:</strong> Potrai cercare e candidarti per programmi di mobilità internazionale presso università partner.
                </p>
                <p class="mb-0">
                    <strong>Per Docenti:</strong> Potrai consultare le opportunità di mobilità e partecipare a programmi di scambio accademico.
                </p>
            </div>
        </div>
    </div>
</div>
