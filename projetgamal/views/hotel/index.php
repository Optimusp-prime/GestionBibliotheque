    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content ">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <div>
                <h1>Gestiom hotels</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Hotel</li>
                    </ol>
                </nav>
            </div>
        </div>



        <!-- ===== SECTION 2 : LISTE ETUDIANTS ===== -->
        <div class="section" id="section-liste ">
            <!-- Alerte succès après action -->
            <!-- <div class="alert-custom alert-success-custom">
                <i class="bi bi-check-circle-fill"></i>
                Étudiant ajouté avec succès.
            </div> -->

            <div class="content-card">
                <div class="card-head">
                    <h5><i class="bi bi-people me-2"></i>Liste des hotels</h5>
                    <a href="index.php?page=hotel&action=create" class="btn-primary-custom">
                        <i class="bi bi-plus-lg"></i> Ajouter
                    </a>
                </div>
                <div class="card-body-custom p-0">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Ville</th>
                                <th>Etoil</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($hotel as $key => $value) { ?>

                                <tr>
                                    <td> <?= $key + 1 ?> </td>
                                    <td><?= $value['nomHotel'] ?> </td>
                                    <td><?= $value['ville'] ?> </td>
                                    <td><?= $value['etoiles'] ?> </td>
                                    <td><?= $value['ouvert'] == 1 ? 'Ouvert' : 'Fermé' ?> </td>
                                    <td>
                                        <a href='index.php?page=hotel&action=edit&id=<?= $value['idHotel'] ?>' class="btn-icon edit"><i class="bi bi-pencil"></i></a>
                                        <a href='index.php?page=hotel&action=delete&id=<?= $value['idHotel'] ?>' class="btn-icon delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet hotel ?')"><i class="bi bi-trash"></i></a>
                                    </td>




                                </tr>




                            <?php }



                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>









    </div>
    <!-- /main-content -->