// archivio-mobilita.js - Gestione archivio mobilità con ricerca e filtri

let currentPage = 1;
let itemsPerPage = 12;
let currentView = 'grid'; // 'grid' o 'list'
let allMobility = [];
let filteredMobility = [];
let currentFilters = {};

document.addEventListener('DOMContentLoaded', function () {
    initializeArchive();
});

/**
 * Inizializza la pagina archivio
 */
function initializeArchive() {
    loadMobilityData();
    setupEventListeners();
    setupViewToggle();
}

/**
 * Carica i dati delle mobilità dal server
 */
function loadMobilityData() {
    showLoadingState();

    fetch('api-mobilita.php?action=getAll')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                allMobility = data.mobilita || [];
                populateCountryFilter();
                applyFilters();
            } else {
                showErrorState(data.errore || 'Errore nel caricamento dei dati');
            }
        })
        .catch(error => {
            console.error('Errore:', error);
            showErrorState('Errore di connessione. Riprova più tardi.');
        });
}

/**
 * Popola il filtro paesi con i paesi disponibili
 */
function populateCountryFilter() {
    const paesi = [...new Set(allMobility.map(m => m.paese).filter(p => p))].sort();
    const paeseSelect = document.getElementById('paese');

    paesi.forEach(paese => {
        const option = document.createElement('option');
        option.value = paese;
        option.textContent = paese;
        paeseSelect.appendChild(option);
    });
}

/**
 * Imposta gli event listener per i controlli
 */
function setupEventListeners() {
    // Filtri
    document.getElementById('applyFilters').addEventListener('click', applyFilters);
    document.getElementById('resetFilters').addEventListener('click', resetFilters);
    document.getElementById('clearFiltersBtn').addEventListener('click', resetFilters);

    // Ricerca in tempo reale (con debounce)
    const searchInput = document.getElementById('searchText');
    let searchTimeout;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 300);
    });

    // Filtri select (applica automaticamente)
    ['tipoMobilita', 'paese', 'durata', 'ordinamento'].forEach(id => {
        document.getElementById(id).addEventListener('change', applyFilters);
    });

    // Filtri avanzati
    ['dataInizio', 'dataFine', 'postiDisponibili'].forEach(id => {
        document.getElementById(id).addEventListener('change', applyFilters);
    });
}

/**
 * Imposta il toggle vista griglia/lista
 */
function setupViewToggle() {
    document.getElementById('viewGrid').addEventListener('click', () => setView('grid'));
    document.getElementById('viewList').addEventListener('click', () => setView('list'));
}

/**
 * Cambia vista (griglia/lista)
 * @param {string} view - 'grid' o 'list'
 */
function setView(view) {
    currentView = view;

    // Aggiorna pulsanti
    document.getElementById('viewGrid').classList.toggle('active', view === 'grid');
    document.getElementById('viewList').classList.toggle('active', view === 'list');

    // Salva preferenza nel localStorage
    localStorage.setItem('mobilityView', view);

    // Ridisegna risultati
    displayResults(filteredMobility);
}

/**
 * Applica i filtri ai dati
 */
function applyFilters() {
    const filters = getCurrentFilters();
    currentFilters = filters;

    filteredMobility = allMobility.filter(mobility => {
        // Filtro ricerca testuale
        if (filters.search) {
            const searchTerm = filters.search.toLowerCase();
            const searchableText = `${mobility.titolo} ${mobility.descrizione} ${mobility.universita_nome} ${mobility.paese}`.toLowerCase();
            if (!searchableText.includes(searchTerm)) {
                return false;
            }
        }

        // Filtro tipo mobilità
        if (filters.tipo && filters.tipo !== '') {
            if (filters.tipo !== 'entrambi' && mobility.tipo_mobilita !== filters.tipo && mobility.tipo_mobilita !== 'entrambi') {
                return false;
            }
        }

        // Filtro paese
        if (filters.paese && filters.paese !== '') {
            if (mobility.paese !== filters.paese) {
                return false;
            }
        }

        // Filtro durata
        if (filters.durata && filters.durata !== '') {
            const mesi = mobility.durata_mesi;
            switch (filters.durata) {
                case '1-3':
                    if (mesi < 1 || mesi > 3) return false;
                    break;
                case '4-6':
                    if (mesi < 4 || mesi > 6) return false;
                    break;
                case '7-12':
                    if (mesi < 7 || mesi > 12) return false;
                    break;
            }
        }

        // Filtro data inizio
        if (filters.data_inizio) {
            const dataInizioMob = new Date(mobility.data_inizio);
            const dataFiltro = new Date(filters.data_inizio);
            if (dataInizioMob < dataFiltro) {
                return false;
            }
        }

        // Filtro data fine
        if (filters.data_fine) {
            const dataFineMob = new Date(mobility.data_fine);
            const dataFiltro = new Date(filters.data_fine);
            if (dataFineMob > dataFiltro) {
                return false;
            }
        }

        // Filtro posti disponibili
        if (filters.posti && filters.posti !== '') {
            const postiLiberi = mobility.posti_disponibili - mobility.posti_prenotati;
            switch (filters.posti) {
                case '1-5':
                    if (postiLiberi < 1 || postiLiberi > 5) return false;
                    break;
                case '6-10':
                    if (postiLiberi < 6 || postiLiberi > 10) return false;
                    break;
                case '11+':
                    if (postiLiberi < 11) return false;
                    break;
            }
        }

        return true;
    });

    // Ordinamento
    sortMobility(filteredMobility, filters.ordina);

    // Reset pagina
    currentPage = 1;

    // Visualizza risultati
    displayResults(filteredMobility);
}

/**
 * Ottiene i filtri correnti dal form
 * @returns {object} Oggetto con i filtri
 */
function getCurrentFilters() {
    return {
        search: document.getElementById('searchText').value.trim(),
        tipo: document.getElementById('tipoMobilita').value,
        paese: document.getElementById('paese').value,
        durata: document.getElementById('durata').value,
        data_inizio: document.getElementById('dataInizio').value,
        data_fine: document.getElementById('dataFine').value,
        posti: document.getElementById('postiDisponibili').value,
        ordina: document.getElementById('ordinamento').value
    };
}

/**
 * Ordina le mobilità
 * @param {Array} mobility - Array di mobilità da ordinare
 * @param {string} orderBy - Campo per ordinamento
 */
function sortMobility(mobility, orderBy) {
    mobility.sort((a, b) => {
        let aVal, bVal;

        switch (orderBy) {
            case 'data_fine':
                aVal = new Date(a.data_fine);
                bVal = new Date(b.data_fine);
                break;
            case 'durata_mesi':
                aVal = a.durata_mesi;
                bVal = b.durata_mesi;
                break;
            case 'posti_disponibili':
                aVal = a.posti_disponibili - a.posti_prenotati;
                bVal = b.posti_disponibili - b.posti_prenotati;
                break;
            case 'universita_nome':
                aVal = a.universita_nome.toLowerCase();
                bVal = b.universita_nome.toLowerCase();
                break;
            case 'data_inizio':
            default:
                aVal = new Date(a.data_inizio);
                bVal = new Date(b.data_inizio);
                break;
        }

        if (aVal < bVal) return -1;
        if (aVal > bVal) return 1;
        return 0;
    });
}

/**
 * Azzera tutti i filtri
 */
function resetFilters() {
    document.getElementById('filterForm').reset();
    document.getElementById('searchText').value = '';
    applyFilters();
}

/**
 * Visualizza i risultati filtrati
 * @param {Array} mobility - Array di mobilità da visualizzare
 */
function displayResults(mobility) {
    const container = document.getElementById('resultsContainer');
    const resultsInfo = document.getElementById('resultsInfo');
    const noResults = document.getElementById('noResultsMessage');
    const pagination = document.getElementById('paginationNav');

    // Aggiorna contatore risultati
    document.getElementById('totalResults').textContent = mobility.length;

    if (mobility.length === 0) {
        container.innerHTML = '';
        noResults.classList.remove('d-none');
        pagination.classList.add('d-none');
        resultsInfo.classList.add('d-none');
        return;
    }

    // Mostra risultati e nascondi messaggio "nessun risultato"
    noResults.classList.add('d-none');
    resultsInfo.classList.remove('d-none');

    // Paginazione
    const totalPages = Math.ceil(mobility.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageMobility = mobility.slice(startIndex, endIndex);

    // Visualizza mobilità della pagina corrente
    container.innerHTML = '';
    pageMobility.forEach(m => {
        const mobilityElement = createMobilityElement(m);
        container.appendChild(mobilityElement);
    });

    // Gestione paginazione
    if (totalPages > 1) {
        pagination.classList.remove('d-none');
        renderPagination(totalPages);
    } else {
        pagination.classList.add('d-none');
    }
}

/**
 * Crea elemento HTML per una mobilità
 * @param {object} mobility - Oggetto mobilità
 * @returns {HTMLElement} Elemento DOM
 */
function createMobilityElement(mobility) {
    const template = document.getElementById(currentView === 'grid' ? 'mobilityCardTemplate' : 'mobilityRowTemplate');
    const clone = template.content.cloneNode(true);

    // Calcoli
    const postiLiberi = mobility.posti_disponibili - mobility.posti_prenotati;
    const percentualePosti = Math.round(((mobility.posti_prenotati / mobility.posti_disponibili) * 100));

    // Popola dati
    clone.querySelector('.titolo').textContent = escapeHtml(mobility.titolo);
    clone.querySelector('.universita-nome').textContent = escapeHtml(mobility.universita_nome);
    clone.querySelector('.paese').textContent = escapeHtml(mobility.paese);
    clone.querySelector('.durata-mesi').textContent = mobility.durata_mesi;
    clone.querySelector('.posti-liberi').textContent = postiLiberi;
    clone.querySelector('.data-inizio').textContent = formatDateIT(mobility.data_inizio);
    clone.querySelector('.data-fine').textContent = formatDateIT(mobility.data_fine);

    // Descrizione troncata
    const descrizione = mobility.descrizione || '';
    clone.querySelector('.descrizione').textContent = descrizione.length > 100 ?
        descrizione.substring(0, 100) + '...' : descrizione;

    // Barra disponibilità
    const progressBar = clone.querySelector('.disponibilita-bar');
    progressBar.style.width = percentualePosti + '%';
    progressBar.setAttribute('aria-valuenow', percentualePosti);
    progressBar.className = 'progress-bar ' + getProgressColorClass(percentualePosti);

    // Badge tipo
    const tipoContainer = clone.querySelector('.tipo-badge-container');
    tipoContainer.innerHTML = getTipoBadge(mobility.tipo_mobilita);

    // Event listeners
    const viewDetailsBtn = clone.querySelector('.view-details-btn');
    const viewFullBtn = clone.querySelector('.view-full-btn');

    viewDetailsBtn.addEventListener('click', () => showMobilityModal(mobility));
    viewFullBtn.href = `dettaglio-mobilita.php?id=${mobility.id_mobilita}`;

    return clone;
}

/**
 * Mostra modal con dettagli mobilità
 * @param {object} mobility - Oggetto mobilità
 */
function showMobilityModal(mobility) {
    const modalBody = document.getElementById('mobilityModalBody');
    const modalTitle = document.getElementById('mobilityModalLabel');
    const viewFullBtn = document.getElementById('viewFullDetailsBtn');

    modalTitle.textContent = `Dettagli: ${mobility.titolo}`;
    viewFullBtn.href = `dettaglio-mobilita.php?id=${mobility.id_mobilita}`;

    const postiLiberi = mobility.posti_disponibili - mobility.posti_prenotati;

    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-8">
                <h5><i class="fas fa-university"></i> ${escapeHtml(mobility.universita_nome)}</h5>
                <p class="text-muted">${escapeHtml(mobility.paese)} - ${escapeHtml(mobility.citta || '')}</p>

                <h6>Descrizione</h6>
                <p>${escapeHtml(mobility.descrizione)}</p>

                ${mobility.requisiti ? `<h6>Requisiti</h6><p>${escapeHtml(mobility.requisiti)}</p>` : ''}
                ${mobility.lingue_richieste ? `<h6>Lingue Richieste</h6><p>${escapeHtml(mobility.lingue_richieste)}</p>` : ''}
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Informazioni</h6>
                        <ul class="list-unstyled">
                            <li><strong>Durata:</strong> ${mobility.durata_mesi} mesi</li>
                            <li><strong>Posti liberi:</strong> ${postiLiberi}/${mobility.posti_disponibili}</li>
                            <li><strong>Inizio:</strong> ${formatDateIT(mobility.data_inizio)}</li>
                            <li><strong>Fine:</strong> ${formatDateIT(mobility.data_fine)}</li>
                            <li><strong>Tipo:</strong> ${getTipoBadge(mobility.tipo_mobilita)}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    `;
}

/**
 * Renderizza la paginazione
 * @param {number} totalPages - Numero totale di pagine
 */
function renderPagination(totalPages) {
    const paginationList = document.getElementById('paginationList');
    paginationList.innerHTML = '';

    // Pulsante precedente
    const prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Precedente"><span aria-hidden="true">&laquo;</span></a>`;
    prevLi.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            displayResults(filteredMobility);
        }
    });
    paginationList.appendChild(prevLi);

    // Pagine
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);

    if (startPage > 1) {
        const li = document.createElement('li');
        li.className = 'page-item';
        li.innerHTML = '<a class="page-link" href="#">1</a>';
        li.addEventListener('click', (e) => {
            e.preventDefault();
            currentPage = 1;
            displayResults(filteredMobility);
        });
        paginationList.appendChild(li);

        if (startPage > 2) {
            const li = document.createElement('li');
            li.className = 'page-item disabled';
            li.innerHTML = '<span class="page-link">...</span>';
            paginationList.appendChild(li);
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener('click', (e) => {
            e.preventDefault();
            currentPage = i;
            displayResults(filteredMobility);
        });
        paginationList.appendChild(li);
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const li = document.createElement('li');
            li.className = 'page-item disabled';
            li.innerHTML = '<span class="page-link">...</span>';
            paginationList.appendChild(li);
        }

        const li = document.createElement('li');
        li.className = 'page-item';
        li.innerHTML = `<a class="page-link" href="#">${totalPages}</a>`;
        li.addEventListener('click', (e) => {
            e.preventDefault();
            currentPage = totalPages;
            displayResults(filteredMobility);
        });
        paginationList.appendChild(li);
    }

    // Pulsante successivo
    const nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Successiva"><span aria-hidden="true">&raquo;</span></a>`;
    nextLi.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++;
            displayResults(filteredMobility);
        }
    });
    paginationList.appendChild(nextLi);
}

/**
 * Ottiene la classe colore per la barra progresso
 * @param {number} percentuale - Percentuale 0-100
 * @returns {string} Classe Bootstrap
 */
function getProgressColorClass(percentuale) {
    if (percentuale < 30) return 'bg-success';
    if (percentuale < 70) return 'bg-warning';
    return 'bg-danger';
}

/**
 * Genera badge per tipo mobilità
 * @param {string} tipo - Tipo mobilità
 * @returns {string} HTML badge
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
 * Mostra stato di caricamento
 */
function showLoadingState() {
    const container = document.getElementById('resultsContainer');
    container.innerHTML = `
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Caricamento mobilità...</span>
            </div>
            <p class="mt-3 text-muted">Caricamento mobilità disponibili...</p>
        </div>
    `;
}

/**
 * Mostra stato di errore
 * @param {string} message - Messaggio di errore
 */
function showErrorState(message) {
    const container = document.getElementById('resultsContainer');
    container.innerHTML = `
        <div class="col-12">
            <div class="alert alert-danger text-center py-5" role="alert">
                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                <h4 class="alert-heading">Errore nel caricamento</h4>
                <p class="mb-3">${escapeHtml(message)}</p>
                <button type="button" class="btn btn-primary" onclick="loadMobilityData()">
                    <i class="fas fa-redo"></i> Riprova
                </button>
            </div>
        </div>
    `;
}

/**
 * Escape HTML per sicurezza
 * @param {string} text - Testo da escapare
 * @returns {string} Testo escapato
 */
function escapeHtml(text) {
    if (typeof text !== 'string') return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}