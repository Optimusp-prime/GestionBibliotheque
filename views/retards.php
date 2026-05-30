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
      <table class="custom-table">
        <thead>
          <tr>
            <th>Etudiant</th>
            <th>Numero</th>
            <th>Livre</th>
            <th>Date emprunt</th>
            <th>Retour prevu</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($retards as $retard): ?>
            <tr>
              <td><?= h($retard['prenom'] . ' ' . $retard['nom']) ?></td>
              <td><?= h($retard['numero_etudiant']) ?></td>
              <td><?= h($retard['titre']) ?></td>
              <td><?= h($retard['date_emprunt']) ?></td>
              <td><?= h($retard['date_retour_prevue']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
