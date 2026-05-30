<?php
require_once "models/Hotel.php";
require_once "models/Reservation.php";


class ReservationController{
    private $reservationModel;

    public function __construct($db)
    {
        $this->reservationModel = new Reservation($db);
    }

    public function index()
    {
        // liste des reservations
        $reservation =  $this->reservationModel->getAllreservation();
        require "views/reservation/index.php";
    }
} 

?>   