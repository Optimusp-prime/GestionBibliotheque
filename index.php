<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/CategorieController.php';
require_once __DIR__ . '/controllers/LivreController.php';
require_once __DIR__ . '/controllers/EtudiantController.php';
require_once __DIR__ . '/controllers/EmpruntController.php';
require_once __DIR__ . '/controllers/StatistiqueController.php';

$baseUrl = '/gbibliotheque';

$database = new Database();
$conn = $database->getConnection();

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$dashboardController = new DashboardController($conn, $baseUrl);
$categorieController = new CategorieController($conn, $baseUrl);
$livreController = new LivreController($conn, $baseUrl);
$etudiantController = new EtudiantController($conn, $baseUrl);
$empruntController = new EmpruntController($conn, $baseUrl);
$statistiqueController = new StatistiqueController($conn, $baseUrl);

switch ($page) {
    case 'categories':
        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $categorieController->create();
        } elseif ($action === 'edit' && $id > 0) {
            $categorieController->edit($id);
        } elseif ($action === 'delete' && $id > 0) {
            $categorieController->delete($id);
        } else {
            $categorieController->index();
        }
        break;

    case 'livres':
        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $livreController->create();
        } elseif ($action === 'edit' && $id > 0) {
            $livreController->edit($id);
        } elseif ($action === 'delete' && $id > 0) {
            $livreController->delete($id);
        } else {
            $livreController->index();
        }
        break;

    case 'etudiants':
        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $etudiantController->create();
        } elseif ($action === 'edit' && $id > 0) {
            $etudiantController->edit($id);
        } elseif ($action === 'delete' && $id > 0) {
            $etudiantController->delete($id);
        } else {
            $etudiantController->index();
        }
        break;

    case 'emprunts':
        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $empruntController->create();
        } elseif ($action === 'retour' && $id > 0) {
            $empruntController->retour($id);
        } else {
            $empruntController->index();
        }
        break;

    case 'retards':
        $statistiqueController->retards();
        break;

    case 'statistiques':
        $statistiqueController->statistiques();
        break;

    case 'dashboard':
    default:
        $dashboardController->index();
        break;
}
