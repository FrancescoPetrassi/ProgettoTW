// login-erasmus.js - Gestione login e registrazione Erasmus

document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const registrationForm = document.getElementById('registrationForm');


    // Gestione form Login
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Validazione client-side
            if (!loginForm.checkValidity() === false) {
                const formData = new FormData(loginForm);
                formData.append('action', 'login');

                const submitButton = loginForm.querySelector('button[type="submit"]');
                setButtonLoading(submitButton, true, 'Accesso in corso...');

                fetch('api-login-erasmus.php', {
                    method: 'POST',
                    body: new URLSearchParams(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.logineseguito) {
                            showAlert('Login effettuato con successo!', 'success', 2000);
                            setTimeout(() => {
                                window.location.href = data.redirect || 'dashboard.php';
                            }, 1500);
                        } else {
                            showAlert(data.errore || 'Errore nel login', 'danger');
                            setButtonLoading(submitButton, false);
                        }
                    })
                    .catch(error => {
                        console.error('Errore:', error);
                        showAlert('Errore durante il login', 'danger');
                        setButtonLoading(submitButton, false);
                    });
            }
        });
    }


    // Gestione form Registrazione
    if (registrationForm) {
        registrationForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Validazione client-side
            if (!registrationForm.checkValidity() === false) {
                // Validazione email
                const email = document.getElementById('emailReg').value;
                if (!validateEmail(email)) {
                    showAlert('Email non valida', 'danger');
                    return;
                }

                // Validazione password
                const password = document.getElementById('passwordReg').value;
                if (password.length < 8) {
                    showAlert('La password deve avere almeno 8 caratteri', 'danger');
                    return;
                }

                const formData = new FormData(registrationForm);
                formData.append('action', 'registrazione');

                const submitButton = registrationForm.querySelector('button[type="submit"]');
                setButtonLoading(submitButton, true, 'Registrazione in corso...');


                fetch('api-login-erasmus.php', {
                    method: 'POST',
                    body: new URLSearchParams(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.logineseguito) {
                            showAlert(data.messaggio || 'Registrazione completata! Effettua il login.', 'success', 3000);
                            
                            // Reset del form
                            registrationForm.reset();
                            registrationForm.classList.remove('was-validated');

                            // Cambia tab al login
                            setTimeout(() => {
                                const loginTab = document.getElementById('login-tab');
                                if (loginTab) {
                                    loginTab.click();
                                    // Pulisci il form login
                                    if (loginForm) {
                                        loginForm.reset();
                                        loginForm.classList.remove('was-validated');
                                    }
                                }
                                setButtonLoading(submitButton, false);
                            }, 1500);
                        } else {
                            showAlert(data.errore || 'Errore nella registrazione', 'danger');
                            setButtonLoading(submitButton, false);
                        }
                    })
                    .catch(error => {
                        console.error('Errore:', error);
                        showAlert('Errore durante la registrazione', 'danger');
                        setButtonLoading(submitButton, false);
                    });
            }
        });

        // Validazione Real-Time email
        const emailInput = document.getElementById('emailReg');
        if (emailInput) {
            emailInput.addEventListener('blur', function () {
                if (this.value && !validateEmail(this.value)) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (this.value) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        }

        // Validazione Real-Time password
        const passwordInput = document.getElementById('passwordReg');
        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                updatePasswordStrength(this.value, 'strengthBar', 'strengthText');

                if (this.value.length < 8) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        }

        // Validazione Real-Time selezionamento ruolo
        const tipoUtenteSelect = document.getElementById('tipoUtente');
        if (tipoUtenteSelect) {
            tipoUtenteSelect.addEventListener('change', function () {
                if (this.value) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        }
    }

    
    // Gestione Tab switching
    const authTabs = document.querySelectorAll('#authTabs button');
    authTabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            // Pulisci messaggi di errore quando cambi tab
            const alerts = document.querySelectorAll('#loginAlert, #registrationAlert');
            alerts.forEach(alert => alert.classList.add('d-none'));
        });
    });
});
