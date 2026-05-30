<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row">
  <div class="col-lg-5">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-book me-2"></i><?= $editLivre ? 'Modifier un livre' : 'Ajouter un livre' ?></h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations du livre</div>
        <form method="POST" action="<?= h($baseUrl) ?>/index.php?page=livres&action=<?= $editLivre ? 'edit&id=' . h($editLivre['id']) : 'create' ?>">
          <div class="mb-3">
            <label class="form-label">Titre <span class="text-danger">*</span></label>
            <input type="text" name="titre" class="form-control" value="<?= h($editLivre['titre'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Auteur <span class="text-danger">*</span></label>
            <input type="text" name="auteur" class="form-control" value="<?= h($editLivre['auteur'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Categorie <span class="text-danger">*</span></label>
            <select name="categorie_id" class="form-select" required>
              <option value="">-- Choisir une categorie --</option>
              <?php foreach ($categories as $categorie): ?>
                <option value="<?= h($categorie['id']) ?>" <?= (int)($editLivre['categorie_id'] ?? 0) === (int)$categorie['id'] ? 'selected' : '' ?>>
                  <?= h($categorie['nom']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Annee <span class="text-danger">*</span></label>
              <input type="number" name="annee" class="form-control" value="<?= h($editLivre['annee'] ?? '') ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Quantite disponible <span class="text-danger">*</span></label>
              <input type="number" name="quantite_disponible" min="0" class="form-control" value="<?= h($editLivre['quantite_disponible'] ?? '0') ?>" required>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Enregistrer</button>
            <?php if ($editLivre): ?>
              <a href="<?= h($baseUrl) ?>/index.php?page=livres" class="btn-secondary-custom"><i class="bi bi-x-lg"></i> Annuler</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-list-ul me-2"></i>Liste des livres</h5>
      </div>
      <div class="card-body-custom">
        <form method="GET" action="<?= h($baseUrl) ?>/index.php" class="d-flex gap-2 mb-3">
          <input type="hidden" name="page" value="livres">
          <input type="text" name="q" class="form-control" placeholder="Rechercher par titre, auteur ou categorie" value="<?= h($search) ?>">
          <button class="btn-primary-custom" type="submit"><i class="bi bi-search"></i> Rechercher</button>
        </form>
      </div>
      <div class="card-body-custom p-0">
        <table class="custom-table table-wide">
          <thead>
            <tr>
              <th class="cell-long">Titre</th>
              <th class="cell-medium">Auteur</th>
              <th class="cell-medium">Categorie</th>
              <th class="cell-small">Annee</th>
              <th class="cell-small">Qte</th>
              <th class="table-actions">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($livres as $livre): ?>
              <tr>
                <td class="cell-long"><?= h($livre['titre']) ?></td>
                <td class="cell-medium"><?= h($livre['auteur']) ?></td>
                <td class="cell-medium"><span class="badge-filiere"><?= h($livre['categorie']) ?></span></td>
                <td class="cell-small"><?= h($livre['annee']) ?></td>
                <td class="cell-small"><?= h($livre['quantite_disponible']) ?></td>
                <td class="table-actions">
                  <span class="action-group">
                    <a class="btn-icon edit" href="<?= h($baseUrl) ?>/index.php?page=livres&action=edit&id=<?= h($livre['id']) ?>"><i class="bi bi-pencil-square"></i></a>
                    <a class="btn-icon delete" href="<?= h($baseUrl) ?>/index.php?page=livres&action=delete&id=<?= h($livre['id']) ?>" onclick="return confirm('Supprimer ce livre ?')"><i class="bi bi-trash"></i></a>
                  </span>
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
