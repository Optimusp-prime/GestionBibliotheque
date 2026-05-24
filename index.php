<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$db = new Database();
$conn = $db->getConnection();

$totalLivres = countRows($conn, 'SELECT COUNT(*) FROM livres');
$totalEtudiants = countRows($conn, 'SELECT COUNT(*) FROM etudiants');
$totalEmprunts = countRows($conn, 'SELECT COUNT(*) FROM emprunts');
$empruntsEnCours = countRows($conn, 'SELECT COUNT(*) FROM emprunts WHERE est_retourne = 0');
$retards = countRows($conn, 'SELECT COUNT(*) FROM emprunts WHERE est_retourne = 0 AND date_retour_prevue < ' . currentDateSql());

$derniersEmprunts = $conn->query("
    SELECT TOP 5 e.id, l.titre, et.nom, et.prenom, e.date_emprunt, e.date_retour_prevue, e.est_retourne
    FROM emprunts e
    INNER JOIN livres l ON l.id = e.livre_id
    INNER JOIN etudiants et ON et.id = e.etudiant_id
    ORDER BY e.id DESC
")->fetchAll();

$pageTitle = 'Tableau de bord';
$pageHeading = 'Tableau de bord';
$activePage = 'dashboard';
$basePath = '.';
include __DIR__ . '/includes/header.php';
?>

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
        <div class="stat-label">Total etudiants</div>
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
    <a href="pages/emprunts/index.php" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Nouvel emprunt</a>
  </div>
  <div class="card-body-custom p-0">
    <?php if (count($derniersEmprunts) === 0): ?>
      <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Aucun emprunt enregistre pour le moment.</p>
      </div>
    <?php else: ?>
      <table class="custom-table">
        <thead>
          <tr>
            <th>Livre</th>
            <th>Etudiant</th>
            <th>Date emprunt</th>
            <th>Retour prevu</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($derniersEmprunts as $emprunt): ?>
            <tr>
              <td><?= h($emprunt['titre']) ?></td>
              <td><?= h($emprunt['prenom'] . ' ' . $emprunt['nom']) ?></td>
              <td><?= h($emprunt['date_emprunt']) ?></td>
              <td><?= h($emprunt['date_retour_prevue']) ?></td>
              <td>
                <span class="badge-filiere"><?= $emprunt['est_retourne'] ? 'Retourne' : 'En cours' ?></span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
