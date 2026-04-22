// home-erasmus.js - Gestione home page Erasmus

document.addEventListener('DOMContentLoaded', function () {
    loadFeaturedMobility();
});

/**
 * Carica le mobilità in evidenza
 */
function loadFeaturedMobility() {
    fetch('api-mobilita.php?action=getRecenti&limit=3')
        .then(response => response.json())
        .then(data => {
            displayMobility(data.mobilita || []);
        })
        .catch(error => {
            console.error('Errore nel caricamento delle mobilità:', error);
            displayMobilityError();
        });
}


/**
 * Visualizza le mobilità nel container
 * @param {Array} mobilita - Array di oggetti mobilità
 */
function displayMobility(mobilita) {
    const container = document.getElementById('mobilityContainer');
    
    if (!container) return;

    if (mobilita.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-info-circle"></i> 
                    Nessuna mobilità disponibile al momento. Torna a visitarci presto!
                </div>
            </div>
        `;
        return;

    }

    let html = '';
    mobilita.forEach(m => {
        const dataInizio = new Date(m.data_inizio);
        const dataFine = new Date(m.data_fine);
        const postiDisponibili = m.posti_disponibili - m.posti_prenotati;
        const percentualePosti = Math.round(((m.posti_prenotati / m.posti_disponibili) * 100));

        html += `
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-light border-0 transition-all">
                    <div class="card-header bg-primary text-white border-0">
                        <span class="badge bg-success">
                            <i class="fas fa-chair"></i> ${postiDisponibili} posti liberi
                        </span>
                        <span class="badge bg-info float-end">
                            <i class="fas fa-clock"></i> ${m.durata_mesi} mesi
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-briefcase"></i> ${escapeHtml(m.titolo)}
                        </h5>
                        <p class="card-text text-muted">
                            <i class="fas fa-university"></i> 
                            <strong>${escapeHtml(m.universita_nome)}</strong><br>
                            <small>${escapeHtml(m.paese)}</small>
                        </p>
                        <p class="card-text small">
                            ${escapeHtml(m.descrizione).substring(0, 100)}...
                        </p>
                        
                        <div class="mb-3">
                            <small class="text-muted">Disponibilità:</small>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-${getProgressColor(percentualePosti)}" 
                                     role="progressbar" 
                                     style="width: ${percentualePosti}%"
                                     aria-valuenow="${percentualePosti}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt"></i> 
                                    ${formatDateIT(dataInizio)}
                                </small>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text-muted">
                                    ${formatDateIT(dataFine)}
                                </small>
                            </div>
                        </div>

                        ${getTipoBadge(m.tipo_mobilita)}
                    </div>
                    <div class="card-footer bg-light border-top-1">
                        <a href="dettaglio-mobilita.php?id=${m.id_mobilita}" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-eye"></i> Scopri di più
                        </a>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

/**
 * Visualizza messaggio di errore
 */
function displayMobilityError() {

    const container = document.getElementById('mobilityContainer');
    if (!container) return;

    container.innerHTML = `
        <div class="col-12">
            <div class="alert alert-danger text-center" role="alert">
                <i class="fas fa-exclamation-triangle"></i> 
                Errore nel caricamento delle mobilità. Per favore, riprova più tardi.
            </div>
        </div>
    `;
}

/**
 * Ottiene il colore della progress bar in base alla percentuale
 * @param {number} percentuale - Percentuale 0-100
 * @returns {string} Classe Bootstrap per il colore
 */
function getProgressColor(percentuale) {

    if (percentuale < 30) return 'success';
    if (percentuale < 70) return 'warning';
    return 'danger';
}

/**
 * Genera il badge del tipo di mobilità
 * @param {string} tipo - Tipo: 'studente', 'professore', 'entrambi'
 * @returns {string} HTML del badge
 */
function getTipoBadge(tipo) {
    const badges = {
        'studente': '<span class="badge bg-info"><i class="fas fa-graduation-cap"></i> Per Studenti</span>',
        'professore': '<span class="badge bg-warning"><i class="fas fa-chalkboard-user"></i> Per Docenti</span>',
        'entrambi': '<span class="badge bg-success"><i class="fas fa-users"></i> Per Tutti</span>'
    };
    return badges[tipo] || '';
    
}

/**
 * Escape HTML per sicurezza
 * @param {string} text - Testo da escapare
 * @returns {string} Testo escapato
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
