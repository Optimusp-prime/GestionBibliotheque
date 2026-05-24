<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';

$db = new Database();
$conn = $db->getConnection();
$self = 'index.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $nbEmprunts = countRows($conn, 'SELECT COUNT(*) FROM emprunts WHERE etudiant_id = ?', [$id]);

    if ($nbEmprunts > 0) {
        redirectWithMessage($self, 'error', 'Impossible de supprimer cet etudiant car il est lie a un emprunt.');
    }

    $stmt = $conn->prepare('DELETE FROM etudiants WHERE id = ?');
    $stmt->execute([$id]);
    redirectWithMessage($self, 'success', 'Etudiant supprime avec succes.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $numero = trim($_POST['numero_etudiant'] ?? '');
    $filiere = trim($_POST['filiere'] ?? '');
    $contact = trim($_POST['contact'] ?? '');

    if ($nom === '' || $prenom === '' || $numero === '' || $filiere === '') {
        redirectWithMessage($self, 'error', 'Tous les champs obligatoires doivent etre remplis.');
    }

    $stmt = $conn->prepare('SELECT COUNT(*) FROM etudiants WHERE numero_etudiant = ? AND id <> ?');
    $stmt->execute([$numero, $id]);
    if ((int) $stmt->fetchColumn() > 0) {
        redirectWithMessage($self, 'error', 'Ce numero etudiant existe deja.');
    }

    if ($id > 0) {
        $stmt = $conn->prepare('
            UPDATE etudiants
            SET nom = ?, prenom = ?, numero_etudiant = ?, filiere = ?, contact = ?
            WHERE id = ?
        ');
        $stmt->execute([$nom, $prenom, $numero, $filiere, $contact, $id]);
        redirectWithMessage($self, 'success', 'Etudiant modifie avec succes.');
    }

    $stmt = $conn->prepare('
        INSERT INTO etudiants (nom, prenom, numero_etudiant, filiere, contact)
        VALUES (?, ?, ?, ?, ?)
    ');
    $stmt->execute([$nom, $prenom, $numero, $filiere, $contact]);
    redirectWithMessage($self, 'success', 'Etudiant ajoute avec succes.');
}

$editEtudiant = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare('SELECT * FROM etudiants WHERE id = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $editEtudiant = $stmt->fetch();
}

$etudiants = $conn->query('SELECT * FROM etudiants ORDER BY nom, prenom')->fetchAll();

$pageTitle = 'Etudiants';
$pageHeading = 'Gestion des etudiants';
$activePage = 'etudiants';
$basePath = '../..';
include __DIR__ . '/../../includes/header.php';
?>

<div class="row">
  <div class="col-lg-5">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-person-plus me-2"></i><?= $editEtudiant ? 'Modifier un etudiant' : 'Ajouter un etudiant' ?></h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations personnelles</div>
        <form method="POST">
          <input type="hidden" name="id" value="<?= h($editEtudiant['id'] ?? '') ?>">
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
              <a href="index.php" class="btn-secondary-custom"><i class="bi bi-x-lg"></i> Annuler</a>
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
                  <a class="btn-icon edit" href="?edit=<?= h($etudiant['id']) ?>"><i class="bi bi-pencil-square"></i></a>
                  <a class="btn-icon delete" href="?delete=<?= h($etudiant['id']) ?>" onclick="return confirm('Supprimer cet etudiant ?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
