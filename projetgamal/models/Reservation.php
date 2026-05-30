<?php


class Reservation
{

    private $conn;
    private $table = "Nom_Reservation";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllreservation()
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
}
