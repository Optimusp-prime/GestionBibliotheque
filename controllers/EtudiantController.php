<?php

require_once __DIR__ . '/../models/Etudiant.php';

class EtudiantController
{
    private $etudiantModel;
    private $baseUrl;

    public function __construct($db, $baseUrl)
    {
        $this->etudiantModel = new Etudiant($db);
        $this->baseUrl = $baseUrl;
    }

    public function index($editEtudiant = null)
    {
        $etudiants = $this->etudiantModel->getAll();
        $pageTitle = 'Etudiants';
        $pageHeading = 'Gestion des etudiants';
        $activePage = 'etudiants';
        $baseUrl = $this->baseUrl;
        require __DIR__ . '/../views/etudiants/index.php';
    }

    public function create()
    {
        $data = $this->readPost();
        $this->validate($data, 0);
        $this->etudiantModel->create($data['nom'], $data['prenom'], $data['numero_etudiant'], $data['filiere'], $data['contact']);
        redirectWithMessage($this->baseUrl . '/index.php?page=etudiants', 'success', 'Etudiant ajoute avec succes.');
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->readPost();
            $this->validate($data, $id);
            $this->etudiantModel->update($id, $data['nom'], $data['prenom'], $data['numero_etudiant'], $data['filiere'], $data['contact']);
            redirectWithMessage($this->baseUrl . '/index.php?page=etudiants', 'success', 'Etudiant modifie avec succes.');
        }

        $editEtudiant = $this->etudiantModel->getById($id);
        $this->index($editEtudiant);
    }

    public function delete($id)
    {
        if ($this->etudiantModel->countEmprunts($id) > 0) {
            redirectWithMessage($this->baseUrl . '/index.php?page=etudiants', 'error', 'Impossible de supprimer cet etudiant car il est lie a un emprunt.');
        }

        $this->etudiantModel->delete($id);
        redirectWithMessage($this->baseUrl . '/index.php?page=etudiants', 'success', 'Etudiant supprime avec succes.');
    }

    private function readPost()
    {
        return [
            'nom' => trim($_POST['nom'] ?? ''),
            'prenom' => trim($_POST['prenom'] ?? ''),
            'numero_etudiant' => trim($_POST['numero_etudiant'] ?? ''),
            'filiere' => trim($_POST['filiere'] ?? ''),
            'contact' => trim($_POST['contact'] ?? ''),
        ];
    }

    private function validate($data, $id)
    {
        if ($data['nom'] === '' || $data['prenom'] === '' || $data['numero_etudiant'] === '' || $data['filiere'] === '') {
            redirectWithMessage($this->baseUrl . '/index.php?page=etudiants', 'error', 'Tous les champs obligatoires doivent etre remplis.');
        }

        if ($this->etudiantModel->numeroExists($data['numero_etudiant'], $id)) {
            redirectWithMessage($this->baseUrl . '/index.php?page=etudiants', 'error', 'Ce numero etudiant existe deja.');
        }
    }
}
