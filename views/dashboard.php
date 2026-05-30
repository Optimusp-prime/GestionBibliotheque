<?php require __DIR__ . '/layout/header.php'; ?>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card blue">
      <div class="stat-icon blue"><i class="bi bi-book"></i></div>
      <div>
        <div class="stat-label">Total livres</div>
        <div class="stat-value"><?= h($totalLivres) ?></div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card gold">
      <div class="stat-icon gold"><i class="bi bi-mortarboard"></i></div>
      <div>
        <div class="stat-label">Total étudiants</div>
        <div class="stat-value"><?= h($totalEtudiants) ?></div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card green">
      <div class="stat-icon green"><i class="bi bi-arrow-left-right"></i></div>
      <div>
        <div class="stat-label">Total emprunts</div>
        <div class="stat-value"><?= h($totalEmprunts) ?></div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card red">
      <div class="stat-icon red"><i class="bi bi-exclamation-triangle"></i></div>
      <div>
        <div class="stat-label">Retards</div>
        <div class="stat-value"><?= h($retards) ?></div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card blue">
      <div class="stat-icon blue"><i class="bi bi-hourglass-split"></i></div>
      <div>
        <div class="stat-label">Emprunts en cours</div>
        <div class="stat-value"><?= h($empruntsEnCours) ?></div>
      </div>
    </div>
  </div>
</div>

<div class="content-card">
  <div class="card-head">
    <h5><i class="bi bi-clock-history me-2"></i>Derniers emprunts</h5>
    <a href="<?= h($baseUrl) ?>/index.php?page=emprunts" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Nouvel emprunt</a>
  </div>
  <div class="card-body-custom p-0">
    <?php if (count($derniersEmprunts) === 0): ?>
      <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Aucun emprunt enregistré pour le moment.</p>
      </div>
    <?php else: ?>
      <table class="custom-table table-wide">
        <thead>
          <tr>
            <th class="cell-long">Livre</th>
            <th class="cell-medium">Étudiant</th>
            <th class="cell-medium">Date d'emprunt</th>
            <th class="cell-medium">Retour prévu</th>
            <th class="cell-medium">Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($derniersEmprunts as $emprunt): ?>
            <tr>
              <td class="cell-long" data-label="Livre"><?= h($emprunt['titre']) ?></td>
              <td class="cell-medium" data-label="Étudiant"><?= h($emprunt['prenom'] . ' ' . $emprunt['nom']) ?></td>
              <td class="cell-medium" data-label="Date d'emprunt"><?= h($emprunt['date_emprunt']) ?></td>
              <td class="cell-medium" data-label="Retour prévu"><?= h($emprunt['date_retour_prevue']) ?></td>
              <td class="cell-medium" data-label="Statut"><span class="badge-filiere"><?= $emprunt['est_retourne'] ? 'Retourné' : 'En cours' ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
