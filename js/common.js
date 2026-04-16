// common.js - Funzioni comuni per Erasmus Mobility Manager

/**
 * Mostra un alert/toast di messaggio
 * @param {string} message - Messaggio da mostrare
 * @param {string} type - Tipo di alert: 'success', 'danger', 'warning', 'info'
 * @param {number} duration - Durata in ms prima di nascondere (0 = non si nasconde)
 */
function showAlert(message, type = 'info', duration = 5000) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alertId = 'alert-' + Date.now();
    const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" id="${alertId}" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
        </div>
    `;

    alertContainer.insertAdjacentHTML('beforeend', alertHTML);

    if (duration > 0) {
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }
        }, duration);
    }
}

/**
 * Effettua il logout dell'utente
 */
function logoutUser() {
    if (!confirm('Sei sicuro di voler fare il logout?')) {
        return;
    }

    fetch('api-login-erasmus.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=logout'
    })
    .then(response => response.json())
    .then(data => {
        window.location.href = 'index.php';
    })
    .catch(error => {
        console.error('Errore nel logout:', error);
        showAlert('Errore durante il logout', 'danger');
    });
}

/**
 * Formatta una data in formato italiano
 * @param {string|Date} date - Data da formattare
 * @returns {string} Data formattata
 */
function formatDateIT(date) {
    if (typeof date === 'string') {
        date = new Date(date);
    }
    
    return new Intl.DateTimeFormat('it-IT', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(date);
}

/**
 * Valida formato email
 * @param {string} email - Email da validare
 * @returns {boolean}
 */
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Valida forza della password
 * @param {string} password - Password da validare
 * @returns {object} { strength: 0-4, text: 'descrizione' }
 */
function validatePasswordStrength(password) {
    let strength = 0;
    let text = 'Molto debole';

    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) strength++;

    switch (strength) {
        case 0:
            text = 'Molto debole';
            break;
        case 1:
            text = 'Debole';
            break;
        case 2:
            text = 'Media';
            break;
        case 3:
            text = 'Forte';
            break;
        case 4:
            text = 'Molto forte';
            break;
    }

    return { strength, text };
}

/**
 * Aggiorna la visualizzazione della forza della password
 * @param {string} password - Password da valutare
 * @param {string} barId - ID della barra di progresso
 * @param {string} textId - ID del testo della forza
 */
function updatePasswordStrength(password, barId = 'strengthBar', textId = 'strengthText') {
    const { strength, text } = validatePasswordStrength(password);
    const bar = document.getElementById(barId);
    const textEl = document.getElementById(textId);

    if (bar) {
        bar.style.width = (strength * 25) + '%';
        bar.setAttribute('aria-valuenow', strength * 25);

        // Colore dinamico della barra
        bar.className = 'progress-bar';
        if (strength === 0) bar.classList.add('bg-danger');
        else if (strength === 1) bar.classList.add('bg-warning');
        else if (strength === 2) bar.classList.add('bg-info');
        else if (strength >= 3) bar.classList.add('bg-success');
    }

    if (textEl) {
        textEl.textContent = text;
        textEl.className = 'text-muted';
        if (strength >= 3) textEl.className = 'text-success';
        else if (strength === 2) textEl.className = 'text-info';
        else if (strength === 1) textEl.className = 'text-warning';
        else textEl.className = 'text-danger';
    }
}

/**
 * Abilita/Disabilita visualizzazione password
 * @param {string} inputId - ID dell'input password
 * @param {string} buttonId - ID del bottone toggle
 */
function setupPasswordToggle(inputId, buttonId) {
    const input = document.getElementById(inputId);
    const button = document.getElementById(buttonId);

    if (!input || !button) return;

    button.addEventListener('click', function (e) {
        e.preventDefault();
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        button.innerHTML = isPassword ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
        button.setAttribute('aria-label', isPassword ? 'Nascondi password' : 'Mostra password');
    });
}

/**
 * Abilita validazione form Bootstrap
 */
function setupFormValidation() {
    const forms = document.querySelectorAll('form[novalidate]');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}

/**
 * Fetch wrapper con gestione errori comune
 * @param {string} url - URL della richiesta
 * @param {object} options - Opzioni fetch
 * @returns {Promise}
 */
async function fetchAPI(url, options = {}) {
    try {
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                ...options.headers
            },
            ...options
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('Errore nella richiesta:', error);
        throw error;
    }
}

/**
 * Disabilita un bottone durante una richiesta
 * @param {HTMLElement} button - Elemento bottone
 * @param {boolean} disable - true per disabilitare, false per abilitare
 * @param {string} loadingText - Testo da mostrare durante il caricamento
 */
function setButtonLoading(button, disable = true, loadingText = 'Caricamento...') {
    if (disable) {
        button.disabled = true;
        button.dataset.originalText = button.innerHTML;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' + loadingText;
    } else {
        button.disabled = false;
        button.innerHTML = button.dataset.originalText || 'Invia';
    }
}

/**
 * Inizializza gli eventi comuni
 */
document.addEventListener('DOMContentLoaded', function () {
    // Setup password toggle
    setupPasswordToggle('password', 'togglePassword');
    setupPasswordToggle('passwordReg', 'togglePasswordReg');

    // Setup form validation
    setupFormValidation();

    // Aggiorna forza password mentre digiti
    const passwordInput = document.getElementById('passwordReg');
    if (passwordInput) {
        passwordInput.addEventListener('input', function () {
            updatePasswordStrength(this.value, 'strengthBar', 'strengthText');
        });
    }
});

// Esporta per moduli (se usato con import)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        showAlert,
        logoutUser,
        formatDateIT,
        validateEmail,
        validatePasswordStrength,
        updatePasswordStrength,
        setupPasswordToggle,
        setupFormValidation,
        fetchAPI,
        setButtonLoading
    };
}
