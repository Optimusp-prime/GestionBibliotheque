  <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content ">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <div>
                <h1>Ghtolel</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Modifcation</li>
                    </ol>
                </nav>
            </div>
        </div>

      
 


  


        <!-- ===== SECTION 4 : FORMULAIRE MODIFICATION ===== -->
        <div class="section" id="section-modification" >
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-card">
                        <div class="card-head">
                            <h5>
                                <i class="bi bi-pencil-square me-2"></i>Modifier l'étudiant
                            </h5>
                        </div>
                        <div class="card-body-custom">
                            <div class="form-section-title">Informations à modifier</div>

                            <form
                                method="POST">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nom Hotel <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="nomhotel"
                                            class="form-control"
                                            value="<?= $hotel['nomHotel'] ?>"
                                            required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ville <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            name="ville"
                                            class="form-control"
                                            value="<?= $hotel['ville'] ?>"
                                            required />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Etoils <span class="text-danger">*</span></label>
                                    <input
                                        type="number"
                                        name="etoils"
                                        class="form-control"
                                        value="<?= $hotel['etoiles'] ?>"
                                     
                                        required />
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Ouverture <span class="text-danger">*</span></label>
                                    <select
                                        name="ouvert"
                                        class="form-select"
                                        required>
                                        <option value="1" <?= $hotel['ouvert'] == 1 ? 'selected' : '' ?>>Ouvert</option>
                                        <option value="0" <?= $hotel['ouvert'] == 0 ? 'selected' : '' ?>>Fermé</option>
                                    </select>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn-primary-custom">
                                        <i class="bi bi-floppy"></i> Mettre à jour
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