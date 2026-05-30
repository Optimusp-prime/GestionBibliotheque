<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row">
  <div class="col-lg-5">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-plus-lg me-2"></i>Enregistrer un emprunt</h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations de l emprunt</div>
        <form method="POST" action="<?= h($baseUrl) ?>/index.php?page=emprunts&action=create">
          <div class="mb-3">
            <label class="form-label">Livre <span class="text-danger">*</span></label>
            <select name="livre_id" class="form-select" required>
              <option value="">-- Choisir un livre --</option>
              <?php foreach ($livres as $livre): ?>
                <option value="<?= h($livre['id']) ?>">
                  <?= h($livre['titre']) ?> (disponible: <?= h($livre['quantite_disponible']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Etudiant <span class="text-danger">*</span></label>
            <select name="etudiant_id" class="form-select" required>
              <option value="">-- Choisir un etudiant --</option>
              <?php foreach ($etudiants as $etudiant): ?>
                <option value="<?= h($etudiant['id']) ?>">
                  <?= h($etudiant['prenom'] . ' ' . $etudiant['nom'] . ' - ' . $etudiant['numero_etudiant']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Date emprunt <span class="text-danger">*</span></label>
              <input type="date" name="date_emprunt" class="form-control" value="<?= h(date('Y-m-d')) ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Retour prevu <span class="text-danger">*</span></label>
              <input type="date" name="date_retour_prevue" class="form-control" required>
            </div>
          </div>
          <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Enregistrer</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-arrow-left-right me-2"></i>Liste des emprunts</h5>
        <div class="d-flex gap-2">
          <a href="<?= h($baseUrl) ?>/index.php?page=emprunts" class="btn-secondary-custom">Tous</a>
          <a href="<?= h($baseUrl) ?>/index.php?page=emprunts&filtre=en_cours" class="btn-primary-custom">En cours</a>
        </div>
      </div>
      <div class="card-body-custom p-0">
        <table class="custom-table">
          <thead>
            <tr>
              <th>Livre</th>
              <th>Etudiant</th>
              <th>Emprunt</th>
              <th>Retour prevu</th>
              <th>Statut</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($emprunts as $emprunt): ?>
              <tr>
                <td><?= h($emprunt['titre']) ?></td>
                <td><?= h($emprunt['prenom'] . ' ' . $emprunt['nom']) ?></td>
                <td><?= h($emprunt['date_emprunt']) ?></td>
                <td><?= h($emprunt['date_retour_prevue']) ?></td>
                <td><span class="badge-filiere"><?= $emprunt['est_retourne'] ? 'Retourne' : 'En cours' ?></span></td>
                <td>
                  <?php if (!$emprunt['est_retourne']): ?>
                    <a class="btn-icon return" href="<?= h($baseUrl) ?>/index.php?page=emprunts&action=retour&id=<?= h($emprunt['id']) ?>" title="Marquer comme retourne"><i class="bi bi-check2-circle"></i></a>
                  <?php else: ?>
                    -
                  <?php endif; ?>
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
