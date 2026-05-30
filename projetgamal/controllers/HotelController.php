<?php


require_once "models/Hotel.php";

class HotelController
{
    private $hotelModel;

    public function __construct($db)
    {
        $this->hotelModel = new Hotel($db);
    }

    public function index()
    {
        // liste des hotels
        $hotel =  $this->hotelModel->getAll();
        require "views/hotel/index.php";
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // recuperation des donnees du formulaire
            $nomhotel = $_POST['nomhotel'];
            $ville = $_POST['ville'];
            $etoiles = $_POST['etoiles'];
            $ouvert = $_POST['ouver'];
            // appel du model pour enregistrer les donnees

            $this->hotelModel->create($nomhotel, $ville, $etoiles, $ouvert);
            header("Location: index.php?page=hotel");
            exit;
        }
        require "views/hotel/create.php";
    }

    public function edit($id)
    {
        $hotel = $this->hotelModel->getById($id)->fetch();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // recuperation des donnees du formulaire
            $nomhotel = $_POST['nomhotel'];
            $ville = $_POST['ville'];
            $etoiles = $_POST['etoils'];
            $ouvert = $_POST['ouvert'];
            // appel du model pour enregistrer les donnees

            $this->hotelModel->update($id, $nomhotel, $ville, $etoiles, $ouvert);
            header("Location: index.php?page=hotel&success=updated");
            exit;
        }
        require "views/hotel/edit.php";
    }

    //fonction pour supprimer un hotel
    public function delete($id)
    {
        $this->hotelModel->delete($id);
        header("Location: index.php?page=hotel");
        exit;
    }
}
