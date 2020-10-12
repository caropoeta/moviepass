<?php 
namespace Process;

require "../Config/Autoload.php";
require "../Config/Config.php";

use Models\Cinema as Cinema;
use Controllers\CinemaController as CinemaController;
use Config\Autoload as Autoload;

Autoload::start();

if (isset($_POST['buttonShowCinemas'])){

    $cinemasController = new CinemaController();

    $cinemasController->GetCinemas();
}

if(isset($_POST['buttonShowCinema'])){
    
    $cinemasController = new CinemaController();
    $cinema= $_POST['wantedCinema'];

    $cinemasController->GetCinema($cinema);
}

if(isset($_POST['buttonDeleteCinema'])){

    $cinemasController = new CinemaController();
    $cinema= $_POST['deleteCinema'];

    $cinemasController->Remove($cinema);
}

if(isset($_POST['buttonModifyCinema'])){

    $cinemasController = new CinemaController();
    $cinema = new Cinema();
    $cinema->setId($_POST['id']);
    $cinema->setName($_POST['name']);
    $cinema->setAdress($_POST['adress']);
    $cinema->setOpeningTime($_POST['openingTime']);
    $cinema->setClosingTime($_POST['closingTime']);
    $cinema->setTicketValue($_POST['ticketValue']);

    $cinemasController->Modify($cinema);
}


?>
