<?Php

require_once 'config/database.php';
require_once 'controllers/HotelController.php';
require_once 'controllers/ReservationController.php';
require_once 'models/statistique.php';

$database = new Database();
$conn = $database->getConnection();
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? '';

$id  = $_GET['id'] ?? null;

$hotelController = new HotelController($conn);
$reservationController = new ReservationController($conn);
$statistique = new statistique($conn);

if ($page === 'hotel') {

    // CREATE POST
    if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $hotelController->create();
        exit;
    }

    // EDIT POST
    if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $hotelController->edit($id);
        exit;
    }
    if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $hotelController->delete($id);
        exit;
    }
}


require  "views/header.php";

if (isset($_GET["success"])) echo '<div class="alert alert-success alert-dismissible ">Opération effectuée avec succès.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';


switch ($page) {

    case 'hotel':

        $hotelController = new HotelController($conn);
        // charment de l'action index
        if ($action == 'create') {
            $hotelController->create();
        } else if ($action == 'edit') {
            $hotelController->edit($_GET['id']);
        } elseif ($action == 'delete') {
            $hotelController->delete($_GET['id']);
        } else {
            $hotelController->index();
        }

        break;

    case 'reservation':

        $reservationController = new ReservationController($conn);
        $reservationController->index();
       

         
        break;
    default:
 $nbreservation = $statistique->countReservations();
        $reservationParHotel = $statistique->countReservationsByHotel();
        $countclient = $statistique->countNbclient();
        $countchambre = $statistique->countNbchambre();
        $counthotel = $statistique->countHotels();
        $counthotel = $statistique->countHotels();
        include "views/statistique.php";

        break;
}






// footer
require  "views/footer.php";
