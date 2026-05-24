<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';

$db = new Database();
$conn = $db->getConnection();
$self = 'index.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $nbLivres = countRows($conn, 'SELECT COUNT(*) FROM livres WHERE categorie_id = ?', [$id]);

    if ($nbLivres > 0) {
        redirectWithMessage($self, 'error', 'Impossible de supprimer cette categorie car elle contient des livres.');
    }

    $stmt = $conn->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$id]);
    redirectWithMessage($self, 'success', 'Categorie supprimee avec succes.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    $nom = trim($_POST['nom'] ?? '');

    if ($nom === '') {
        redirectWithMessage($self, 'error', 'Le nom de la categorie est obligatoire.');
    }

    if ($id > 0) {
        $stmt = $conn->prepare('UPDATE categories SET nom = ? WHERE id = ?');
        $stmt->execute([$nom, $id]);
        redirectWithMessage($self, 'success', 'Categorie modifiee avec succes.');
    }

    $stmt = $conn->prepare('INSERT INTO categories (nom) VALUES (?)');
    $stmt->execute([$nom]);
    redirectWithMessage($self, 'success', 'Categorie ajoutee avec succes.');
}

$editCategorie = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare('SELECT * FROM categories WHERE id = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $editCategorie = $stmt->fetch();
}

$categories = $conn->query("
    SELECT c.id, c.nom, COUNT(l.id) AS nombre_livres
    FROM categories c
    LEFT JOIN livres l ON l.categorie_id = c.id
    GROUP BY c.id, c.nom
    ORDER BY c.nom
")->fetchAll();

$pageTitle = 'Categories';
$pageHeading = 'Gestion des categories';
$activePage = 'categories';
$basePath = '../..';
include __DIR__ . '/../../includes/header.php';
?>

<div class="row">
  <div class="col-lg-5">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-tags me-2"></i><?= $editCategorie ? 'Modifier une categorie' : 'Ajouter une categorie' ?></h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations</div>
        <form method="POST">
          <input type="hidden" name="id" value="<?= h($editCategorie['id'] ?? '') ?>">
          <div class="mb-3">
            <label class="form-label">Nom <span class="text-danger">*</span></label>
            <input type="text" name="nom" class="form-control" value="<?= h($editCategorie['nom'] ?? '') ?>" required>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Enregistrer</button>
            <?php if ($editCategorie): ?>
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
        <h5><i class="bi bi-list-ul me-2"></i>Liste des categories</h5>
      </div>
      <div class="card-body-custom p-0">
        <table class="custom-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nom</th>
              <th>Livres</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $categorie): ?>
              <tr>
                <td><?= h($categorie['id']) ?></td>
                <td><?= h($categorie['nom']) ?></td>
                <td><?= h($categorie['nombre_livres']) ?></td>
                <td>
                  <a class="btn-icon edit" href="?edit=<?= h($categorie['id']) ?>"><i class="bi bi-pencil-square"></i></a>
                  <a class="btn-icon delete" href="?delete=<?= h($categorie['id']) ?>" onclick="return confirm('Supprimer cette categorie ?')"><i class="bi bi-trash"></i></a>
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
