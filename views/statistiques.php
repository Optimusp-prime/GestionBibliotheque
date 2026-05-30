<?php require __DIR__ . '/layout/header.php'; ?>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card green">
      <div class="stat-icon green"><i class="bi bi-arrow-left-right"></i></div>
      <div>
        <div class="stat-label">Nombre total d emprunts</div>
        <div class="stat-value"><?= h($totalEmprunts) ?></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-tags me-2"></i>Livres par categorie</h5>
      </div>
      <div class="card-body-custom p-0">
        <table class="custom-table">
          <thead>
            <tr>
              <th class="cell-long">Categorie</th>
              <th class="cell-medium">Nombre de livres</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($livresParCategorie as $row): ?>
              <tr>
                <td class="cell-long"><?= h($row['nom']) ?></td>
                <td class="cell-medium"><?= h($row['total']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-book me-2"></i>Livres les plus empruntes</h5>
      </div>
      <div class="card-body-custom p-0">
        <table class="custom-table">
          <thead>
            <tr>
              <th class="cell-long">Livre</th>
              <th class="cell-medium">Emprunts</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($livresPlusEmpruntes as $row): ?>
              <tr>
                <td class="cell-long"><?= h($row['titre']) ?></td>
                <td class="cell-medium"><?= h($row['total']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="content-card">
  <div class="card-head">
    <h5><i class="bi bi-mortarboard me-2"></i>Etudiants qui empruntent le plus</h5>
  </div>
  <div class="card-body-custom p-0">
    <table class="custom-table">
      <thead>
        <tr>
          <th class="cell-medium">Etudiant</th>
          <th class="cell-medium">Numero</th>
          <th class="cell-medium">Emprunts</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($etudiantsPlusActifs as $row): ?>
          <tr>
            <td class="cell-medium"><?= h($row['prenom'] . ' ' . $row['nom']) ?></td>
            <td class="cell-medium"><?= h($row['numero_etudiant']) ?></td>
            <td class="cell-medium"><?= h($row['total']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
