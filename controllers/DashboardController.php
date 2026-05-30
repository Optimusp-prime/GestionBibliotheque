<?php

require_once __DIR__ . '/../models/Statistique.php';

class DashboardController
{
    private $statistiqueModel;
    private $baseUrl;

    public function __construct($db, $baseUrl)
    {
        $this->statistiqueModel = new Statistique($db);
        $this->baseUrl = $baseUrl;
    }

    public function index()
    {
        $totalLivres = $this->statistiqueModel->totalLivres();
        $totalEtudiants = $this->statistiqueModel->totalEtudiants();
        $totalEmprunts = $this->statistiqueModel->totalEmprunts();
        $empruntsEnCours = $this->statistiqueModel->empruntsEnCours();
        $retards = $this->statistiqueModel->nombreRetards();
        $derniersEmprunts = $this->statistiqueModel->derniersEmprunts();

        $pageTitle = 'Tableau de bord';
        $pageHeading = 'Tableau de bord';
        $activePage = 'dashboard';
        $baseUrl = $this->baseUrl;
        require __DIR__ . '/../views/dashboard.php';
    }
}
