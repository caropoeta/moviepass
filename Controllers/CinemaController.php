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
        $removed=$cinemaDAO->Remove($cinema);

        if($removed){
            echo "The cinema: " . $cinema ." was deleted ";
        }else{
            echo "The cinema: " . $cinema . " Don't found";
        }
        require_once(VIEWS_PATH . 'indexCinema.php');
    }

    public function ModifyCinema($modifyId)
    {
        require_once(VIEWS_PATH . 'navbaradmin.php');
        $cinemaDAO= new CinemaDAO();
        $cinemaList=$cinemaDAO->GetAll();
        $cinemaFound= new Cinema();

        foreach ($cinemaList as $oneCinema) {

         if($modifyId==$oneCinema->getId()){

             $cinemaFound=$oneCinema;
         }
     }
     require_once(VIEWS_PATH . 'cinema.php');
 }
 public function UpdateCinema($id,$name,$adress,$openingTime,$closingTime,$ticketValue,$capacity)
 {

    $cinema=new Cinema();
    $cinema->setId($id);
    $cinema->setName($name);
    $cinema->setAdress($adress);
    $cinema->setOpeningTime($openingTime);
    $cinema->setClosingTime($closingTime);
    $cinema->setTicketValue($ticketValue);
    $cinema->setCapacity($capacity);

    $cinemaDAO= new CinemaDAO;
    $cinemaDAO->Update($cinema);


    require_once(VIEWS_PATH . 'indexCinema.php');
}

}




?>
