<?php

require_once __DIR__ . '/../models/Livre.php';
require_once __DIR__ . '/../models/Categorie.php';

class LivreController
{
    private $livreModel;
    private $categorieModel;
    private $baseUrl;

    public function __construct($db, $baseUrl)
    {
        $this->livreModel = new Livre($db);
        $this->categorieModel = new Categorie($db);
        $this->baseUrl = $baseUrl;
    }

    public function index($editLivre = null)
    {
        $search = trim($_GET['q'] ?? '');
        $livres = $this->livreModel->getAll($search);
        $categories = $this->categorieModel->getAll();
        $pageTitle = 'Livres';
        $pageHeading = 'Gestion des livres';
        $activePage = 'livres';
        $baseUrl = $this->baseUrl;
        require __DIR__ . '/../views/livres/index.php';
    }

    public function create()
    {
        $data = $this->readPost();
        $this->validate($data);
        $this->livreModel->create($data['titre'], $data['auteur'], $data['categorie_id'], $data['annee'], $data['quantite_disponible']);
        redirectWithMessage($this->baseUrl . '/index.php?page=livres', 'success', 'Livre ajoute avec succes.');
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->readPost();
            $this->validate($data);
            $this->livreModel->update($id, $data['titre'], $data['auteur'], $data['categorie_id'], $data['annee'], $data['quantite_disponible']);
            redirectWithMessage($this->baseUrl . '/index.php?page=livres', 'success', 'Livre modifie avec succes.');
        }

        $editLivre = $this->livreModel->getById($id);
        $this->index($editLivre);
    }

    public function delete($id)
    {
        if ($this->livreModel->countEmprunts($id) > 0) {
            redirectWithMessage($this->baseUrl . '/index.php?page=livres', 'error', 'Impossible de supprimer ce livre car il est lie a un emprunt.');
        }

        $this->livreModel->delete($id);
        redirectWithMessage($this->baseUrl . '/index.php?page=livres', 'success', 'Livre supprime avec succes.');
    }

    private function readPost()
    {
        return [
            'titre' => trim($_POST['titre'] ?? ''),
            'auteur' => trim($_POST['auteur'] ?? ''),
            'categorie_id' => (int) ($_POST['categorie_id'] ?? 0),
            'annee' => trim($_POST['annee'] ?? ''),
            'quantite_disponible' => (int) ($_POST['quantite_disponible'] ?? 0),
        ];
    }

    private function validate($data)
    {
        if ($data['titre'] === '' || $data['auteur'] === '' || $data['categorie_id'] <= 0 || $data['annee'] === '') {
            redirectWithMessage($this->baseUrl . '/index.php?page=livres', 'error', 'Tous les champs obligatoires doivent etre remplis.');
        }

        if ($data['quantite_disponible'] < 0) {
            redirectWithMessage($this->baseUrl . '/index.php?page=livres', 'error', 'La quantite disponible ne peut pas etre negative.');
        }
    }
}
