<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row">
  <div class="col-lg-5">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-person-plus me-2"></i><?= $editEtudiant ? 'Modifier un etudiant' : 'Ajouter un etudiant' ?></h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations personnelles</div>
        <form method="POST" action="<?= h($baseUrl) ?>/index.php?page=etudiants&action=<?= $editEtudiant ? 'edit&id=' . h($editEtudiant['id']) : 'create' ?>">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Nom <span class="text-danger">*</span></label>
              <input type="text" name="nom" class="form-control" value="<?= h($editEtudiant['nom'] ?? '') ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Prenom <span class="text-danger">*</span></label>
              <input type="text" name="prenom" class="form-control" value="<?= h($editEtudiant['prenom'] ?? '') ?>" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Numero etudiant <span class="text-danger">*</span></label>
            <input type="text" name="numero_etudiant" class="form-control" value="<?= h($editEtudiant['numero_etudiant'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Filiere <span class="text-danger">*</span></label>
            <input type="text" name="filiere" class="form-control" value="<?= h($editEtudiant['filiere'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" name="contact" class="form-control" value="<?= h($editEtudiant['contact'] ?? '') ?>">
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Enregistrer</button>
            <?php if ($editEtudiant): ?>
              <a href="<?= h($baseUrl) ?>/index.php?page=etudiants" class="btn-secondary-custom"><i class="bi bi-x-lg"></i> Annuler</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-people me-2"></i>Liste des etudiants</h5>
      </div>
      <div class="card-body-custom p-0">
        <table class="custom-table">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Prenom</th>
              <th>Numero</th>
              <th>Filiere</th>
              <th>Contact</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($etudiants as $etudiant): ?>
              <tr>
                <td><?= h($etudiant['nom']) ?></td>
                <td><?= h($etudiant['prenom']) ?></td>
                <td><?= h($etudiant['numero_etudiant']) ?></td>
                <td><span class="badge-filiere"><?= h($etudiant['filiere']) ?></span></td>
                <td><?= h($etudiant['contact']) ?></td>
                <td>
                  <a class="btn-icon edit" href="<?= h($baseUrl) ?>/index.php?page=etudiants&action=edit&id=<?= h($etudiant['id']) ?>"><i class="bi bi-pencil-square"></i></a>
                  <a class="btn-icon delete" href="<?= h($baseUrl) ?>/index.php?page=etudiants&action=delete&id=<?= h($etudiant['id']) ?>" onclick="return confirm('Supprimer cet etudiant ?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
