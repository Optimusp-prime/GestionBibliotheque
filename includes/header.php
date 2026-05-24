<?php
require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? 'Gestion Bibliotheque';
$pageHeading = $pageHeading ?? $pageTitle;
$activePage = $activePage ?? '';
$basePath = $basePath ?? '.';
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= h($pageTitle) ?></title>
    <link href="<?= h($basePath) ?>/src/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= h($basePath) ?>/src/bootstrap-icons-1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?= h($basePath) ?>/assets/css/app.css" rel="stylesheet" />
  </head>
  <body>
    <div class="topbar">
      <a href="<?= h($basePath) ?>/index.php" class="brand">Gestion <span>Bibliotheque</span></a>
      <div class="topbar-right">
        <span class="user-name">Bibliotheque universitaire</span>
        <div class="avatar">BU</div>
      </div>
    </div>

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">
      <div class="page-header">
        <div>
          <h1><?= h($pageHeading) ?></h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= h($basePath) ?>/index.php">Accueil</a></li>
              <li class="breadcrumb-item active"><?= h($pageHeading) ?></li>
            </ol>
          </nav>
        </div>
      </div>
      <?php showMessage(); ?>
