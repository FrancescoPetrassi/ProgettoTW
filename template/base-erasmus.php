<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Erasmus Mobility Manager - Gestione della mobilità internazionale Erasmus per studenti e docenti">
    <meta name="theme-color" content="#0d47a1">
    <title><?php echo isset($templateParams["titolo"]) ? $templateParams["titolo"] : "Erasmus Mobility Manager"; ?></title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome per icone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Personalizzato -->
    <link rel="stylesheet" type="text/css" href="./css/style-erasmus.css">
</head>
<body>
    <!-- Skip Link per accessibilità -->
    <a href="#main-content" class="btn btn-primary position-absolute top-0 start-0 translate-middle-y" style="margin-left: -1000px;">Salta al contenuto principale</a>
    
    <!-- Header -->
    <header class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top" role="banner">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-globe"></i> Erasmus Mobility Manager
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Attiva/disattiva navigazione">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" aria-current="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'page' : 'false'; ?>">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="archivio-mobilita.php">
                            <i class="fas fa-list"></i> Archivio Mobilità
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contatti.php">
                            <i class="fas fa-envelope"></i> Contatti
                        </a>
                    </li>
                    <?php if(isUserLoggedInErasmus()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> <?php echo getFullName(); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?php echo isAdmin() ? 'admin-dashboard.php' : 'dashboard.php'; ?>">
                                        <i class="fas fa-dashboard"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="profilo.php">
                                        <i class="fas fa-user-edit"></i> Il Mio Profilo
                                    </a>
                                </li>
                                <?php if(isAdmin()): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="admin-dashboard.php">
                                            <i class="fas fa-cog"></i> Admin
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="logoutUser()" role="button">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light ms-2" href="login-erasmus.php">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="flex-grow-1">
        <!-- Alert/Toast per messaggi di sistema -->
        <div id="alertContainer" class="container-fluid mt-3"></div>

        <?php
        if(isset($templateParams["nome"])){
            require($templateParams["nome"]);
        }
        ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5" role="contentinfo">
        <div class="container">
            <p class="mb-2">
                <strong>Erasmus Mobility Manager</strong><br>
                Gestione della mobilità internazionale tra università partner
            </p>
            <p class="text-muted mb-0">
                Progetto Tecnologie Web - A.A. 2025/2026<br>
                <small>Realizzato con HTML, CSS, PHP, JavaScript e Bootstrap</small>
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle (include Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script comune per gestione UI -->
    <script src="js/common.js"></script>

    <!-- Script aggiuntivi specificati nel template -->
    <?php
    if(isset($templateParams["js"])):
        foreach($templateParams["js"] as $script):
    ?>
        <script src="<?php echo $script; ?>"></script>
    <?php
        endforeach;
    endif;
    ?>
</body>
</html>
