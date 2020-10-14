<?php

namespace Controllers;

use DAO\CinemaDAO as CinemaDAO;
use Models\Cinema as Cinema;

class CinemaController
{
    public function __construct()
    {
        SessionController::ValidateSession();
    }

    public function Index()
    {
        require_once(VIEWS_PATH . 'indexCinema.php');
    }

    public function AddCinema(Cinema $cinemaToAdd){

        $cinemaDAO= new CinemaDAO();
        $cinemaDAO->Add($cinemaToAdd);
        require_once(VIEWS_PATH . 'showCinemas.php');

    }

    public function ShowCinemas()
    {
        $cinemaDAO= new CinemaDAO();
        $cinemaList=$cinemaDAO->GetAll();

        require_once(VIEWS_PATH . 'showCinemas.php');
    }

    public function ShowCinema($cinemaSearched)
    {
        $cinemaDAO= new CinemaDAO();
        $cinemas=$cinemaDAO->GetAll();

        foreach ($cinemas as $cinema) {
            if(strcmp($cinema->getName(),$cinemaSearched)==0){
                $cinemaFound=$cinema;
            }
        }
        
        require_once(VIEWS_PATH . 'showCinema.php');
    }

    public function DeleteCinema($cinema)
    {
        $cinemaDAO= new CinemaDAO;
        $cinemaDAO->Remove($cinema);
        
        require_once(VIEWS_PATH . 'indexCinema.php');
    }

    public function ModifyCinema($id, $name, $adress, $openingTime, $closingTime, $ticketValue)
    {

        $cinemaDAO= new CinemaDAO();
        $cinemaList=$cinemaDAO->GetAll();

        foreach ($cinemaList as $oneCinema) {
            if($id==$oneCinema->getId()){
                $oneCinema->setName($name);
                $oneCinema->setAdress($adress);
                $oneCinema->setOpeningTime($openingTime);
                $oneCinema->setClosingTime($closingTime);
                $oneCinema->setTicketValue($ticketValue);
            }
        }

        $cinemaDAO->AddAll($cinemaList);
        require_once(VIEWS_PATH . 'indexCinema.php');

    }
}
?>
