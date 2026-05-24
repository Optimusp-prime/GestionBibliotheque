<?php
$items = [
    'dashboard' => ['Tableau de bord', 'bi-grid-1x2', $basePath . '/index.php'],
    'livres' => ['Livres', 'bi-book', $basePath . '/pages/livres/index.php'],
    'categories' => ['Categories', 'bi-tags', $basePath . '/pages/categories/index.php'],
    'etudiants' => ['Etudiants', 'bi-mortarboard', $basePath . '/pages/etudiants/index.php'],
    'emprunts' => ['Emprunts', 'bi-arrow-left-right', $basePath . '/pages/emprunts/index.php'],
    'retards' => ['Retards', 'bi-exclamation-triangle', $basePath . '/pages/retards.php'],
    'statistiques' => ['Statistiques', 'bi-bar-chart', $basePath . '/pages/statistiques.php'],
];
?>
<div class="sidebar">
  <div class="sidebar-section-title">Navigation</div>
  <?php foreach ($items as $key => $item): ?>
    <a href="<?= h($item[2]) ?>" class="<?= $activePage === $key ? 'active' : '' ?>">
      <i class="bi <?= h($item[1]) ?>"></i> <?= h($item[0]) ?>
    </a>
  <?php endforeach; ?>
</div>
