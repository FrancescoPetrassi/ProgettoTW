<!-- filepath: template/contatti-erasmus.php -->
<div class="container py-5">
    <h1 class="mb-4"><i class="fas fa-university me-2"></i>Contatti delle Università Partner</h1>
    <p class="lead mb-4">Di seguito trovi l'elenco delle università partner con i relativi contatti per informazioni sulla mobilità Erasmus.</p>
    
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="table-primary">
                <tr>
                    <th scope="col"><i class="fas fa-graduation-cap me-1"></i>Università</th>
                    <th scope="col"><i class="fas fa-map-marker-alt me-1"></i>Paese</th>
                    <th scope="col"><i class="fas fa-city me-1"></i>Città</th>
                    <th scope="col"><i class="fas fa-envelope me-1"></i>Email</th>
                    <th scope="col"><i class="fas fa-globe me-1"></i>Sito Web</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($templateParams["university_list"])): ?>
                    <?php foreach($templateParams["university_list"] as $uni): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($uni["nome"]); ?></strong></td>
                            <td><?php echo htmlspecialchars($uni["paese"]); ?></td>
                            <td><?php echo htmlspecialchars($uni["citta"]); ?></td>
                            <td>
                                <a href="mailto:<?php echo htmlspecialchars($uni["email_contatto"]); ?>" class="text-decoration-none">
                                    <?php echo htmlspecialchars($uni["email_contatto"]); ?>
                                </a>
                            </td>
                            <td>
                                <?php if(!empty($uni["sito_web"])): ?>
                                    <a href="<?php echo htmlspecialchars($uni["sito_web"]); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                        <i class="fas fa-external-link-alt me-1"></i>Visita
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="fas fa-info-circle me-2"></i>Nessuna università partner disponibile al momento.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="mt-5 p-4 bg-light rounded">
        <h3><i class="fas fa-question-circle me-2"></i> Hai bisogno di assistenza?</h3>
        <p>Per domande generali sul programma Erasmus o problemi tecnici, contatta l'amministratore del sistema.</p>
        <a href="mailto:admin@erasmus.it" class="btn btn-primary">
            <i class="fas fa-envelope me-2"></i>Contatta l'Amministratore
        </a>
    </div>
</div>