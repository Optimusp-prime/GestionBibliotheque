<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';

$db = new Database();
$conn = $db->getConnection();
$self = 'index.php';

if (isset($_GET['retour'])) {
    $id = (int) $_GET['retour'];

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare('SELECT id, livre_id, est_retourne FROM emprunts WHERE id = ?');
        $stmt->execute([$id]);
        $emprunt = $stmt->fetch();

        if (!$emprunt) {
            $conn->rollBack();
            redirectWithMessage($self, 'error', 'Emprunt introuvable.');
        }

        if ((int) $emprunt['est_retourne'] === 1) {
            $conn->rollBack();
            redirectWithMessage($self, 'warning', 'Cet emprunt est deja retourne.');
        }

        $stmt = $conn->prepare('UPDATE emprunts SET est_retourne = 1 WHERE id = ?');
        $stmt->execute([$id]);

        $stmt = $conn->prepare('UPDATE livres SET quantite_disponible = quantite_disponible + 1 WHERE id = ?');
        $stmt->execute([$emprunt['livre_id']]);

        $conn->commit();
        redirectWithMessage($self, 'success', 'Livre marque comme retourne.');
    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        redirectWithMessage($self, 'error', 'Erreur pendant le retour du livre.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $livreId = (int) ($_POST['livre_id'] ?? 0);
    $etudiantId = (int) ($_POST['etudiant_id'] ?? 0);
    $dateEmprunt = $_POST['date_emprunt'] ?? '';
    $dateRetourPrevue = $_POST['date_retour_prevue'] ?? '';

    if ($livreId <= 0 || $etudiantId <= 0 || $dateEmprunt === '' || $dateRetourPrevue === '') {
        redirectWithMessage($self, 'error', 'Tous les champs sont obligatoires.');
    }

    if ($dateRetourPrevue < $dateEmprunt) {
        redirectWithMessage($self, 'error', 'La date de retour prevue doit etre superieure ou egale a la date d emprunt.');
    }

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare('SELECT id, quantite_disponible FROM livres WHERE id = ?');
        $stmt->execute([$livreId]);
        $livre = $stmt->fetch();

        if (!$livre || (int) $livre['quantite_disponible'] <= 0) {
            $conn->rollBack();
            redirectWithMessage($self, 'error', 'Ce livre n est pas disponible pour un emprunt.');
        }

        $stmt = $conn->prepare('
            INSERT INTO emprunts (livre_id, etudiant_id, date_emprunt, date_retour_prevue, est_retourne)
            VALUES (?, ?, ?, ?, 0)
        ');
        $stmt->execute([$livreId, $etudiantId, $dateEmprunt, $dateRetourPrevue]);

        $stmt = $conn->prepare('UPDATE livres SET quantite_disponible = quantite_disponible - 1 WHERE id = ? AND quantite_disponible > 0');
        $stmt->execute([$livreId]);

        $conn->commit();
        redirectWithMessage($self, 'success', 'Emprunt enregistre avec succes.');
    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        redirectWithMessage($self, 'error', 'Erreur pendant l enregistrement de l emprunt.');
    }
}

$livres = $conn->query('SELECT id, titre, quantite_disponible FROM livres ORDER BY titre')->fetchAll();
$etudiants = $conn->query('SELECT id, nom, prenom, numero_etudiant FROM etudiants ORDER BY nom, prenom')->fetchAll();

$filtre = $_GET['filtre'] ?? '';
$sql = "
    SELECT e.id, e.date_emprunt, e.date_retour_prevue, e.est_retourne,
           l.titre, et.nom, et.prenom, et.numero_etudiant
    FROM emprunts e
    INNER JOIN livres l ON l.id = e.livre_id
    INNER JOIN etudiants et ON et.id = e.etudiant_id
";

if ($filtre === 'en_cours') {
    $sql .= ' WHERE e.est_retourne = 0';
}

$sql .= ' ORDER BY e.id DESC';
$emprunts = $conn->query($sql)->fetchAll();

$pageTitle = 'Emprunts';
$pageHeading = 'Gestion des emprunts';
$activePage = 'emprunts';
$basePath = '../..';
include __DIR__ . '/../../includes/header.php';
?>

<div class="row">
  <div class="col-lg-5">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-plus-lg me-2"></i>Enregistrer un emprunt</h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations de l emprunt</div>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Livre <span class="text-danger">*</span></label>
            <select name="livre_id" class="form-select" required>
              <option value="">-- Choisir un livre --</option>
              <?php foreach ($livres as $livre): ?>
                <option value="<?= h($livre['id']) ?>">
                  <?= h($livre['titre']) ?> (disponible: <?= h($livre['quantite_disponible']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Etudiant <span class="text-danger">*</span></label>
            <select name="etudiant_id" class="form-select" required>
              <option value="">-- Choisir un etudiant --</option>
              <?php foreach ($etudiants as $etudiant): ?>
                <option value="<?= h($etudiant['id']) ?>">
                  <?= h($etudiant['prenom'] . ' ' . $etudiant['nom'] . ' - ' . $etudiant['numero_etudiant']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Date emprunt <span class="text-danger">*</span></label>
              <input type="date" name="date_emprunt" class="form-control" value="<?= h(date('Y-m-d')) ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Retour prevu <span class="text-danger">*</span></label>
              <input type="date" name="date_retour_prevue" class="form-control" required>
            </div>
          </div>
          <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Enregistrer</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-arrow-left-right me-2"></i>Liste des emprunts</h5>
        <div class="d-flex gap-2">
          <a href="index.php" class="btn-secondary-custom">Tous</a>
          <a href="?filtre=en_cours" class="btn-primary-custom">En cours</a>
        </div>
      </div>
      <div class="card-body-custom p-0">
        <table class="custom-table">
          <thead>
            <tr>
              <th>Livre</th>
              <th>Etudiant</th>
              <th>Emprunt</th>
              <th>Retour prevu</th>
              <th>Statut</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($emprunts as $emprunt): ?>
              <tr>
                <td><?= h($emprunt['titre']) ?></td>
                <td><?= h($emprunt['prenom'] . ' ' . $emprunt['nom']) ?></td>
                <td><?= h($emprunt['date_emprunt']) ?></td>
                <td><?= h($emprunt['date_retour_prevue']) ?></td>
                <td><span class="badge-filiere"><?= $emprunt['est_retourne'] ? 'Retourne' : 'En cours' ?></span></td>
                <td>
                  <?php if (!$emprunt['est_retourne']): ?>
                    <a class="btn-icon return" href="?retour=<?= h($emprunt['id']) ?>" title="Marquer comme retourne"><i class="bi bi-check2-circle"></i></a>
                  <?php else: ?>
                    -
                  <?php endif; ?>
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
