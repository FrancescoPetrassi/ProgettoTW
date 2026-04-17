<div class="container">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index-erasmus.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-list"></i> Archivio Mobilità
                    </li>
                </ol>
            </nav>

            <h1 class="display-5 fw-bold mb-3">
                <i class="fas fa-search"></i> Archivio Mobilità Erasmus
            </h1>
            <p class="lead text-muted">
                Esplora tutte le opportunità di mobilità internazionale disponibili presso le nostre università partner.
            </p>
        </div>
    </div>

    <!-- Filtri di Ricerca -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h2 class="h5 mb-0">
                        <i class="fas fa-filter"></i> Filtri di Ricerca
                    </h2>
                </div>
                <div class="card-body">
                    <form id="filterForm" class="row g-3">
                        <!-- Ricerca Testuale -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <label for="searchText" class="form-label">
                                <i class="fas fa-search"></i> Cerca
                            </label>
                            <input type="text" class="form-control" id="searchText" name="search"
                                   placeholder="Titolo, descrizione, università..." aria-describedby="searchHelp">
                            <small id="searchHelp" class="form-text text-muted">
                                Cerca per parole chiave nel titolo o descrizione
                            </small>
                        </div>

                        <!-- Tipo Mobilità -->
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="tipoMobilita" class="form-label">
                                <i class="fas fa-user-graduate"></i> Tipo
                            </label>
                            <select class="form-select" id="tipoMobilita" name="tipo">
                                <option value="">Tutti i tipi</option>
                                <option value="studente">Studenti</option>
                                <option value="professore">Docenti</option>
                                <option value="entrambi">Entrambi</option>
                            </select>
                        </div>

                        <!-- Paese -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="paese" class="form-label">
                                <i class="fas fa-globe"></i> Paese
                            </label>
                            <select class="form-select" id="paese" name="paese">
                                <option value="">Tutti i paesi</option>
                                <!-- Opzioni paesi caricate dinamicamente -->
                            </select>
                        </div>

                        <!-- Durata -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="durata" class="form-label">
                                <i class="fas fa-clock"></i> Durata (mesi)
                            </label>
                            <select class="form-select" id="durata" name="durata">
                                <option value="">Qualsiasi durata</option>
                                <option value="1-3">1-3 mesi</option>
                                <option value="4-6">4-6 mesi</option>
                                <option value="7-12">7-12 mesi</option>
                            </select>
                        </div>

                        <!-- Pulsanti -->
                        <div class="col-12">
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-primary" id="applyFilters">
                                    <i class="fas fa-search"></i> Applica Filtri
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                                    <i class="fas fa-undo"></i> Azzera Filtri
                                </button>
                                <button type="button" class="btn btn-outline-info" id="toggleFilters" data-bs-toggle="collapse" data-bs-target="#advancedFilters">
                                    <i class="fas fa-sliders-h"></i> Filtri Avanzati
                                </button>
                            </div>
                        </div>

                        <!-- Filtri Avanzati (Collassabili) -->
                        <div class="col-12 collapse" id="advancedFilters">
                            <div class="row g-3 border-top pt-3">
                                <div class="col-12 col-md-6">
                                    <label for="dataInizio" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Data Inizio (da)
                                    </label>
                                    <input type="date" class="form-control" id="dataInizio" name="data_inizio">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="dataFine" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Data Fine (a)
                                    </label>
                                    <input type="date" class="form-control" id="dataFine" name="data_fine">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="postiDisponibili" class="form-label">
                                        <i class="fas fa-chair"></i> Posti Disponibili
                                    </label>
                                    <select class="form-select" id="postiDisponibili" name="posti">
                                        <option value="">Qualsiasi disponibilità</option>
                                        <option value="1-5">1-5 posti</option>
                                        <option value="6-10">6-10 posti</option>
                                        <option value="11+">Più di 10 posti</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="ordinamento" class="form-label">
                                        <i class="fas fa-sort"></i> Ordina per
                                    </label>
                                    <select class="form-select" id="ordinamento" name="ordina">
                                        <option value="data_inizio">Data inizio</option>
                                        <option value="data_fine">Data fine</option>
                                        <option value="durata_mesi">Durata</option>
                                        <option value="posti_disponibili">Posti disponibili</option>
                                        <option value="universita_nome">Università</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Risultati e Statistiche -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div id="resultsInfo" class="mb-2 mb-md-0">
                    <span class="badge bg-primary fs-6">
                        <i class="fas fa-list"></i> <span id="totalResults">0</span> mobilità trovate
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="viewGrid">
                        <i class="fas fa-th"></i> Griglia
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="viewList">
                        <i class="fas fa-list-ul"></i> Lista
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Container Risultati -->
    <div id="resultsContainer" class="row g-4">
        <!-- I risultati verranno caricati qui via JavaScript -->
        <div class="col-12 text-center">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Caricamento mobilità...</span>
            </div>
            <p class="mt-2 text-muted">Caricamento mobilità disponibili...</p>
        </div>
    </div>

    <!-- Paginazione -->
    <div class="row mt-4">
        <div class="col-12">
            <nav id="paginationNav" aria-label="Navigazione pagine risultati" class="d-none">
                <ul class="pagination justify-content-center" id="paginationList">
                    <!-- Paginazione generata dinamicamente -->
                </ul>
            </nav>
        </div>
    </div>

    <!-- Messaggio Nessun Risultato -->
    <div id="noResultsMessage" class="row d-none">
        <div class="col-12">
            <div class="alert alert-info text-center py-5" role="alert">
                <div class="mb-3">
                    <i class="fas fa-search fa-3x text-info"></i>
                </div>
                <h4 class="alert-heading">Nessuna mobilità trovata</h4>
                <p class="mb-3">
                    Non sono state trovate mobilità che corrispondano ai tuoi criteri di ricerca.
                </p>
                <button type="button" class="btn btn-primary" id="clearFiltersBtn">
                    <i class="fas fa-undo"></i> Azzera tutti i filtri
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Dettagli Mobilità (per vista rapida) -->
    <div class="modal fade" id="mobilityModal" tabindex="-1" aria-labelledby="mobilityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mobilityModalLabel">
                        <i class="fas fa-info-circle"></i> Dettagli Mobilità
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body" id="mobilityModalBody">
                    <!-- Contenuto caricato dinamicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Chiudi
                    </button>
                    <a href="#" class="btn btn-primary" id="viewFullDetailsBtn">
                        <i class="fas fa-eye"></i> Vedi Dettagli Completi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template per Card Mobilità (usato da JavaScript) -->
<template id="mobilityCardTemplate">
    <div class="col-12 col-md-6 col-lg-4 mobility-item">
        <div class="card h-100 shadow-light border-0 transition-all">
            <div class="card-header bg-primary text-white border-0">
                <span class="badge bg-success posti-badge">
                    <i class="fas fa-chair"></i> <span class="posti-liberi">0</span> posti liberi
                </span>
                <span class="badge bg-info float-end durata-badge">
                    <i class="fas fa-clock"></i> <span class="durata-mesi">0</span> mesi
                </span>
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-briefcase"></i> <span class="titolo"></span>
                </h5>
                <p class="card-text text-muted">
                    <i class="fas fa-university"></i>
                    <strong class="universita-nome"></strong><br>
                    <small class="paese"></small>
                </p>
                <p class="card-text small descrizione">
                    <!-- Descrizione troncata -->
                </p>

                <div class="mb-3">
                    <small class="text-muted">Disponibilità:</small>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar disponibilita-bar" role="progressbar"
                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="data-inizio"></span>
                        </small>
                    </div>
                    <div class="col-6 text-end">
                        <small class="text-muted">
                            <span class="data-fine"></span>
                        </small>
                    </div>
                </div>

                <div class="tipo-badge-container">
                    <!-- Badge tipo mobilità -->
                </div>
            </div>
            <div class="card-footer bg-light border-top-1">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm view-details-btn" data-bs-toggle="modal" data-bs-target="#mobilityModal">
                        <i class="fas fa-eye"></i> Anteprima
                    </button>
                    <a href="#" class="btn btn-primary btn-sm view-full-btn">
                        <i class="fas fa-external-link-alt"></i> Dettagli Completi
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Template per Riga Lista Mobilità -->
<template id="mobilityRowTemplate">
    <div class="col-12 mobility-item">
        <div class="card shadow-light border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="card-title mb-2">
                            <i class="fas fa-briefcase"></i> <span class="titolo"></span>
                        </h5>
                        <p class="card-text mb-2">
                            <i class="fas fa-university"></i>
                            <strong class="universita-nome"></strong> (<span class="paese"></span>)
                        </p>
                        <p class="card-text small text-muted descrizione">
                            <!-- Descrizione troncata -->
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Durata</small>
                                    <strong class="durata-mesi">0</strong> mesi
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Posti liberi</small>
                                    <strong class="posti-liberi">0</strong>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="data-inizio"></span> - <span class="data-fine"></span>
                            </small>
                        </div>
                        <div class="mt-2 tipo-badge-container">
                            <!-- Badge tipo mobilità -->
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-outline-primary btn-sm view-details-btn" data-bs-toggle="modal" data-bs-target="#mobilityModal">
                                <i class="fas fa-eye"></i> Anteprima
                            </button>
                            <a href="#" class="btn btn-primary btn-sm view-full-btn">
                                <i class="fas fa-external-link-alt"></i> Dettagli Completi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>