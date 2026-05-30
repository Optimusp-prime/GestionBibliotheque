<?php

require_once __DIR__ . '/../models/Emprunt.php';
require_once __DIR__ . '/../models/Livre.php';
require_once __DIR__ . '/../models/Etudiant.php';

class EmpruntController
{
    private $empruntModel;
    private $livreModel;
    private $etudiantModel;
    private $baseUrl;

    public function __construct($db, $baseUrl)
    {
        $this->empruntModel = new Emprunt($db);
        $this->livreModel = new Livre($db);
        $this->etudiantModel = new Etudiant($db);
        $this->baseUrl = $baseUrl;
    }

    public function index()
    {
        $filtre = $_GET['filtre'] ?? '';
        $emprunts = $this->empruntModel->getAll($filtre === 'en_cours');
        $livres = $this->livreModel->getAvailableForSelect();
        $etudiants = $this->etudiantModel->getAll();
        $pageTitle = 'Emprunts';
        $pageHeading = 'Gestion des emprunts';
        $activePage = 'emprunts';
        $baseUrl = $this->baseUrl;
        require __DIR__ . '/../views/emprunts/index.php';
    }

    public function create()
    {
        $livreId = (int) ($_POST['livre_id'] ?? 0);
        $etudiantId = (int) ($_POST['etudiant_id'] ?? 0);
        $dateEmprunt = $_POST['date_emprunt'] ?? '';
        $dateRetourPrevue = $_POST['date_retour_prevue'] ?? '';

        if ($livreId <= 0 || $etudiantId <= 0 || $dateEmprunt === '' || $dateRetourPrevue === '') {
            redirectWithMessage($this->baseUrl . '/index.php?page=emprunts', 'error', 'Tous les champs sont obligatoires.');
        }

        if ($dateRetourPrevue < $dateEmprunt) {
            redirectWithMessage($this->baseUrl . '/index.php?page=emprunts', 'error', 'La date de retour prevue doit etre superieure ou egale a la date d emprunt.');
        }

        $result = $this->empruntModel->create($livreId, $etudiantId, $dateEmprunt, $dateRetourPrevue);

        if ($result === 'indisponible') {
            redirectWithMessage($this->baseUrl . '/index.php?page=emprunts', 'error', 'Ce livre n est pas disponible pour un emprunt.');
        }

        if ($result !== 'ok') {
            redirectWithMessage($this->baseUrl . '/index.php?page=emprunts', 'error', 'Erreur pendant l enregistrement de l emprunt.');
        }

        redirectWithMessage($this->baseUrl . '/index.php?page=emprunts', 'success', 'Emprunt enregistre avec succes.');
    }

    public function retour($id)
    {
        $result = $this->empruntModel->retour($id);

        if ($result === 'introuvable') {
            redirectWithMessage($this->baseUrl . '/index.php?page=emprunts', 'error', 'Emprunt introuvable.');
        }

        if ($result === 'deja_retourne') {
            redirectWithMessage($this->baseUrl . '/index.php?page=emprunts', 'warning', 'Cet emprunt est deja retourne.');
        }

        if ($result !== 'ok') {
            redirectWithMessage($this->baseUrl . '/index.php?page=emprunts', 'error', 'Erreur pendant le retour du livre.');
        }

        redirectWithMessage($this->baseUrl . '/index.php?page=emprunts', 'success', 'Livre marque comme retourne.');
    }
}
