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
        $cinema = new Cinema();
        $cinema->setId($id);
        $cinema->setName($name);
        $cinema->setAdress($adress);
        $cinema->setOpeningTime($openingTime);
        $cinema->setClosingTime($closingTime);
        $cinema->setTicketValue($ticketValue);

        $cinemaDAO= new CinemaDAO();
        $cinemaList=$cinemaDAO->GetAll();

        foreach ($cinemaList as $oneCinema) {
            if($cinema->getId()==$oneCinema->getId()){
                $oneCinema->setName($cinema->getName());
                $oneCinema->setAdress($cinema->getAdress());
                $oneCinema->setOpeningTime($cinema->getOpeningTime());
                $oneCinema->setClosingTime($cinema->getClosingTime());
                $oneCinema->setTicketValue($cinema->getTicketValue());
            }
        }
        
        $cinemaDAO->AddAll($cinemaList);
        
        require_once(VIEWS_PATH . 'indexCinema.php');
    }
}
