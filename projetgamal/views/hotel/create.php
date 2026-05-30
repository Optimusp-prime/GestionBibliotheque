    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <div>
                <h1>Gestion Hotel</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Hotel</li>
                    </ol>
                </nav>
            </div>
        </div>


        <!-- ===== SECTION 3 : FORMULAIRE AJOUT ===== -->
        <div class="section" id="section-formulaire ">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-card">
                        <div class="card-head">
                            <h5>
                                <i class="bi bi-person-plus me-2"></i>Ajouter un Hotel
                            </h5>
                        </div>
                        <div class="card-body-custom">
                            <form method="post" >
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nom hotel<span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="nomhotel"
                                            class="form-control"
                                            placeholder="Ex : hotel de la paix"
                                            required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ville <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="ville"
                                            class="form-control"
                                            placeholder="Ex : Conakry"
                                            required />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Etoil</label>
                                    <input
                                        type="number"
                                        name="etoiles"
                                        class="form-control"
                                        placeholder="Ex : 4" />
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">ouvert <span class="text-danger">*</span></label>
                                    <select name="ouver" class="form-select" required>
                                        <option value="">-- Choisir une option --</option>
                                        <option value="0">Non</option>
                                        <option value="1">Oui</option>  
                                    </select>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn-primary-custom">
                                        <i class="bi bi-floppy"></i> Enregistrer
                                    </button>
                                    <a href="liste.php" class="btn-secondary-custom">
                                        <i class="bi bi-x-lg"></i> Annuler
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
       
            </div>
        </div>



  




    </div>
    <!-- /main-content -->
