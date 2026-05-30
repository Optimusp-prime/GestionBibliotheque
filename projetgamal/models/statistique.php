<?php

class statistique
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    //fonction pour compter le nombre de reservations
    public function countReservations()
    {
        try {
            $query = "SELECT COUNT(*) FROM Nom_Reservation";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetch()['total'];
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }


    //fonction pour compter le nombre d'hotels
    public function countHotels()
    {
        try {
            $query = "SELECT COUNT(*) as total FROM Nom_Hotel";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetch()['total'];
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }


    public function countNbchambre()
    {
        try {
            $query = "SELECT COUNT(*) as total FROM Nom_Chambre";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetch()['total'];
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }

    public function countNbclient()
    {
        try {
            $query = "SELECT count(*) as total FROM Nom_Client";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetch()['total'];
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }


    // nombre de resevation par hotels
    public function countReservationsByHotel()
    {
        try {
            $query = "SELECT h.nomHotel, COUNT(r.idReservation) as total 
        FROM Nom_Hotel h
        inner join NOM_Chambre ch on ch.idHotel = h.idHotel
        inner JOIN Nom_Reservation r
        ON ch.idChambre = r.idChambre GROUP BY h.idHotel,h.nomHotel";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }
}
