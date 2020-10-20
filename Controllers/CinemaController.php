<?php

namespace Controllers;

use DAO\CinemaDAO as CinemaDAO;
use Models\Cinema as Cinema;
use Models\PopupAlert;

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


    public function AddCinema($id, $name, $adress, $openingTime, $closingTime, $ticketValue,$capacity)
    {
        $cinemaToAdd = new Cinema();
        $cinemaToAdd->setId($id);
        $cinemaToAdd->setName($name);
        $cinemaToAdd->setAdress($adress);
        $cinemaToAdd->setOpeningTime($openingTime);
        $cinemaToAdd->setClosingTime($closingTime);
        $cinemaToAdd->setTicketValue($ticketValue);
        $cinemaToAdd->setCapacity($capacity);

        $cinemaDAO = new CinemaDAO();
        $cinemaDAO->Add($cinemaToAdd);

        $cinemaList = $cinemaDAO->GetAll();
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
    //Borrado logico
    public function DeleteCinema($deleteId)
    {
        $cinemaDAO= new CinemaDAO;
        $delete=$cinemaDAO->Remove($deleteId);
        if($delete==true)
        {
            $popupAlert=new PopupAlert(["Message:","Cinema removed"]);
            $popupAlert->Show();
        }
        require_once(VIEWS_PATH . 'indexCinema.php');
    }
    //Borrado fisico
        /*
        $cinemaDAO= new CinemaDAO;
        $removed=$cinemaDAO->Remove($cinema);
  
        if($removed){

            echo "The cinema: " . $cinema ." was deleted ";
        }else{
            echo "The cinema: " . $cinema . " Don't found";
        }
        require_once(VIEWS_PATH . 'indexCinema.php');
    }
        */

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

    if ($ticketValue>0){
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
    }else{
        echo '<script language="javascript">';
        echo "alert('The ticket must be positive!!');";
        echo '</script>';
    }
    require_once(VIEWS_PATH . 'indexCinema.php');
}

}
?>