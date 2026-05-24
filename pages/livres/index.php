<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';

$db = new Database();
$conn = $db->getConnection();
$self = 'index.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $nbEmprunts = countRows($conn, 'SELECT COUNT(*) FROM emprunts WHERE livre_id = ?', [$id]);

    if ($nbEmprunts > 0) {
        redirectWithMessage($self, 'error', 'Impossible de supprimer ce livre car il est lie a un emprunt.');
    }

    $stmt = $conn->prepare('DELETE FROM livres WHERE id = ?');
    $stmt->execute([$id]);
    redirectWithMessage($self, 'success', 'Livre supprime avec succes.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    $titre = trim($_POST['titre'] ?? '');
    $auteur = trim($_POST['auteur'] ?? '');
    $categorieId = (int) ($_POST['categorie_id'] ?? 0);
    $annee = trim($_POST['annee'] ?? '');
    $quantite = (int) ($_POST['quantite_disponible'] ?? 0);

    if ($titre === '' || $auteur === '' || $categorieId <= 0 || $annee === '') {
        redirectWithMessage($self, 'error', 'Tous les champs obligatoires doivent etre remplis.');
    }

    if ($quantite < 0) {
        redirectWithMessage($self, 'error', 'La quantite disponible ne peut pas etre negative.');
    }

    if ($id > 0) {
        $stmt = $conn->prepare('
            UPDATE livres
            SET titre = ?, auteur = ?, categorie_id = ?, annee = ?, quantite_disponible = ?
            WHERE id = ?
        ');
        $stmt->execute([$titre, $auteur, $categorieId, $annee, $quantite, $id]);
        redirectWithMessage($self, 'success', 'Livre modifie avec succes.');
    }

    $stmt = $conn->prepare('
        INSERT INTO livres (titre, auteur, categorie_id, annee, quantite_disponible)
        VALUES (?, ?, ?, ?, ?)
    ');
    $stmt->execute([$titre, $auteur, $categorieId, $annee, $quantite]);
    redirectWithMessage($self, 'success', 'Livre ajoute avec succes.');
}

$editLivre = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare('SELECT * FROM livres WHERE id = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $editLivre = $stmt->fetch();
}

$categories = $conn->query('SELECT id, nom FROM categories ORDER BY nom')->fetchAll();

$search = trim($_GET['q'] ?? '');
$params = [];
$sql = "
    SELECT l.id, l.titre, l.auteur, l.annee, l.quantite_disponible, c.nom AS categorie
    FROM livres l
    INNER JOIN categories c ON c.id = l.categorie_id
";

if ($search !== '') {
    $sql .= " WHERE l.titre LIKE ? OR l.auteur LIKE ? OR c.nom LIKE ?";
    $like = '%' . $search . '%';
    $params = [$like, $like, $like];
}

$sql .= ' ORDER BY l.titre';
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$livres = $stmt->fetchAll();

$pageTitle = 'Livres';
$pageHeading = 'Gestion des livres';
$activePage = 'livres';
$basePath = '../..';
include __DIR__ . '/../../includes/header.php';
?>

<div class="row">
  <div class="col-lg-5">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-book me-2"></i><?= $editLivre ? 'Modifier un livre' : 'Ajouter un livre' ?></h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations du livre</div>
        <form method="POST">
          <input type="hidden" name="id" value="<?= h($editLivre['id'] ?? '') ?>">
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
        <h5><i class="bi bi-list-ul me-2"></i>Liste des livres</h5>
      </div>
      <div class="card-body-custom">
        <form method="GET" class="d-flex gap-2 mb-3">
          <input type="text" name="q" class="form-control" placeholder="Rechercher par titre, auteur ou categorie" value="<?= h($search) ?>">
          <button class="btn-primary-custom" type="submit"><i class="bi bi-search"></i> Rechercher</button>
        </form>
      </div>
      <div class="card-body-custom p-0">
        <table class="custom-table">
          <thead>
            <tr>
              <th>Titre</th>
              <th>Auteur</th>
              <th>Categorie</th>
              <th>Annee</th>
              <th>Qté</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($livres as $livre): ?>
              <tr>
                <td><?= h($livre['titre']) ?></td>
                <td><?= h($livre['auteur']) ?></td>
                <td><span class="badge-filiere"><?= h($livre['categorie']) ?></span></td>
                <td><?= h($livre['annee']) ?></td>
                <td><?= h($livre['quantite_disponible']) ?></td>
                <td>
                  <a class="btn-icon edit" href="?edit=<?= h($livre['id']) ?>"><i class="bi bi-pencil-square"></i></a>
                  <a class="btn-icon delete" href="?delete=<?= h($livre['id']) ?>" onclick="return confirm('Supprimer ce livre ?')"><i class="bi bi-trash"></i></a>
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
