<?php

class Hotel
{

    private $conn;
    private $table = "Nom_Hotel";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //recuperer un hotel a travers son id
    public function getById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE idHotel = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt;
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }



    //methode pour modifier un hotel
    public function update($id, $nomhotel, $ville, $etoiles, $ouvert)
    {
        try {
            $sql = "UPDATE " . $this->table . " SET nomHotel = ?, ville = ?, etoiles = ?, ouvert = ? WHERE idHotel = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$nomhotel, $ville, $etoiles, $ouvert, $id]);
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $query = "SELECT * FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }

    //ajout d'un hotel
    public function create($nomhotel, $ville, $etoiles, $ouvert)
    {
        //script requete
        $sql = "INSERT into NOM_Hotel (nomHotel,ville,etoiles,ouvert) values(?,?,?,?)";
        //la requete préparée
        $stmt = $this->conn->prepare($sql);
        //l'execution de la requete
        $stmt->execute([$nomhotel, $ville, $etoiles, $ouvert]);
    }


    //fonction pour supprimer un hotel
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM " . $this->table . " WHERE idHotel = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }
}
