<?php require __DIR__ . '/layout/header.php'; ?>

<div class="content-card">
  <div class="card-head">
    <h5><i class="bi bi-exclamation-triangle me-2"></i>Liste des retards</h5>
  </div>
  <div class="card-body-custom p-0">
    <?php if (count($retards) === 0): ?>
      <div class="empty-state">
        <i class="bi bi-check2-circle"></i>
        <p>Aucun retard pour le moment.</p>
      </div>
    <?php else: ?>
      <table class="custom-table table-wide">
        <thead>
          <tr>
            <th class="cell-medium">Etudiant</th>
            <th class="cell-medium">Numero</th>
            <th class="cell-long">Livre</th>
            <th class="cell-medium">Date emprunt</th>
            <th class="cell-medium">Retour prevu</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($retards as $retard): ?>
            <tr>
              <td class="cell-medium"><?= h($retard['prenom'] . ' ' . $retard['nom']) ?></td>
              <td class="cell-medium"><?= h($retard['numero_etudiant']) ?></td>
              <td class="cell-long"><?= h($retard['titre']) ?></td>
              <td class="cell-medium"><?= h($retard['date_emprunt']) ?></td>
              <td class="cell-medium"><?= h($retard['date_retour_prevue']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
