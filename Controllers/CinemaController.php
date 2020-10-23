<?php

namespace Controllers;

use DAO\CinemaDAO as CinemaDAO;
use Models\Cinema as Cinema;
use Models\PopupAlert;
use DAO\Session;

class CinemaController
{
    public function __construct()
    {
        Session::ValidateSession();
    }

    public function Index()
    {
        require_once(VIEWS_PATH . 'indexCinema.php');
    }


    public function AddCinema($name, $adress, $openingTime, $closingTime, $ticketValue,$capacity)
    {
        $cinemaDAO = new CinemaDAO();
        $cinemaList = $cinemaDAO->GetAll();

        $idMax=1;
        foreach ($cinemaList as $oneCinema) {
            if($oneCinema->getId()>$idMax){
                $idMax=$oneCinema->getId();
            }
        }
        $newId=$idMax+1;
        $errorMessage="";
        $hasError=false;
        if($ticketValue<=0){
            $hasError=true;
            $errorMessage= $errorMessage . "The ticket value must be positive" . '\n';

        } 
        if($capacity<=0){
            $hasError=true;
            $errorMessage= $errorMessage . "The capacity value must be positive" . '\n';
        }
        if($hasError == false){
            $cinemaToAdd = new Cinema();
            $cinemaToAdd->setId($newId);
            $cinemaToAdd->setName($name);
            $cinemaToAdd->setAdress($adress);
            $cinemaToAdd->setOpeningTime($openingTime);
            $cinemaToAdd->setClosingTime($closingTime);
            $cinemaToAdd->setTicketValue($ticketValue);
            $cinemaToAdd->setCapacity($capacity);
            $cinemaToAdd->setDelete(false);

            $cinemaDAO->Add($cinemaToAdd);
            $cinemaList = $cinemaDAO->GetAll();
        }
        else {
            $popupAlert=new PopupAlert(["Error:", $errorMessage]);
            $popupAlert->Show();
        }
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

    if ($ticketValue>0 && $capacity>0){

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
    }else {
        $popupAlert=new PopupAlert(["Error:","Must enter a positive value, enter again"]);
        $popupAlert->Show();
    }
    require_once(VIEWS_PATH . 'indexCinema.php');
}

}
?>
