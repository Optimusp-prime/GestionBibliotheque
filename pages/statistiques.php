<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$db = new Database();
$conn = $db->getConnection();

$livresParCategorie = $conn->query("
    SELECT c.nom, COUNT(l.id) AS total
    FROM categories c
    LEFT JOIN livres l ON l.categorie_id = c.id
    GROUP BY c.nom
    ORDER BY c.nom
")->fetchAll();

$totalEmprunts = countRows($conn, 'SELECT COUNT(*) FROM emprunts');

$livresPlusEmpruntes = $conn->query("
    SELECT TOP 10 l.titre, COUNT(e.id) AS total
    FROM emprunts e
    INNER JOIN livres l ON l.id = e.livre_id
    GROUP BY l.titre
    ORDER BY total DESC
")->fetchAll();

$etudiantsPlusActifs = $conn->query("
    SELECT TOP 10 et.nom, et.prenom, et.numero_etudiant, COUNT(e.id) AS total
    FROM emprunts e
    INNER JOIN etudiants et ON et.id = e.etudiant_id
    GROUP BY et.nom, et.prenom, et.numero_etudiant
    ORDER BY total DESC
")->fetchAll();

$pageTitle = 'Statistiques';
$pageHeading = 'Statistiques simples';
$activePage = 'statistiques';
$basePath = '..';
include __DIR__ . '/../includes/header.php';
?>

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
              <th>Categorie</th>
              <th>Nombre de livres</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($livresParCategorie as $row): ?>
              <tr>
                <td><?= h($row['nom']) ?></td>
                <td><?= h($row['total']) ?></td>
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
              <th>Livre</th>
              <th>Emprunts</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($livresPlusEmpruntes as $row): ?>
              <tr>
                <td><?= h($row['titre']) ?></td>
                <td><?= h($row['total']) ?></td>
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
          <th>Etudiant</th>
          <th>Numero</th>
          <th>Emprunts</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($etudiantsPlusActifs as $row): ?>
          <tr>
            <td><?= h($row['prenom'] . ' ' . $row['nom']) ?></td>
            <td><?= h($row['numero_etudiant']) ?></td>
            <td><?= h($row['total']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
