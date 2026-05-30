
    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <div>
                <h1>Gestion Hotel</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Tableau de board</li>
                    </ol>
                </nav>
            </div>
        </div>

      
      
   

        <!-- ===== SECTION 1 : STATISTIQUES ===== -->
        <div class="demo-section active " id="section-stats">
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card blue">
                        <div class="stat-icon blue"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="stat-label">Total Hotels</div>
                            <div class="stat-value"><?= $counthotel ?? 0?> </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card gold">
                        <div class="stat-icon gold"><i class="bi bi-diagram-3"></i></div>
                        <div>
                            <div class="stat-label">Nombre de chambres</div>
                            <div class="stat-value"><?= $countchambre ?? 0?> </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card green">
                        <div class="stat-icon green">
                            <i class="bi bi-check2-circle"></i>
                        </div>
                        <div>
                            <div class="stat-label">Nombre de clients</div>
                            <div class="stat-value"><?= $countclient ?? 0?> </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card red">
                        <div class="stat-icon red"><i class="bi bi-x-circle"></i></div>
                        <div>
                            <div class="stat-label">Nombre de réservations</div>
                            <div class="stat-value"><?= $nbreservation ?? 0?> </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <div class="card-head">
                    <h5><i class="bi bi-bar-chart me-2"></i>Étudiants par filière</h5>
                </div>
                <div class="card-body-custom">
                    <p class="text-muted" style="font-size: 0.85rem">
                        Ce bloc peut contenir un graphique Chart.js dynamique branché sur
                        SQL Server via PHP. Exemple d'intégration : récupérer
                        <code>COUNT(*) GROUP BY FiliereID</code> et passer les données à
                        Chart.js.
                    </p>
                    <!-- Simulation d'un graphique en barres CSS -->
                    <div
                        style="
                display: flex;
                gap: 12px;
                align-items: flex-end;
                height: 120px;
                margin-top: 1rem;
              "></div>
                </div>
            </div>
        </div>

  



    </div>
    <!-- /main-content -->