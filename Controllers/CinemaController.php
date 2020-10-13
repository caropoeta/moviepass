<?php
namespace Controllers;

use Dao\CinemaDAO as CinemaDAO;
use Models\Cinema as Cinema;


class CinemaController{

    public function __construct()
    {
        if (!isset($_SESSION['current_user']))
            $_SESSION['current_user'] = null;
    }

    public function AddCinema(Cinema $cinemaToAdd){

        $cinemaDAO= new CinemaDAO();

        $cinemaDAO->Add($cinemaToAdd);

    }

    public function GetCinemas(){
        $cinemaDAO= new CinemaDAO();

        $cinemaList=$cinemaDAO->GetAll();
        //Muestro lo encontrado para probar, borrar cuando este la vista hecha.
        foreach ($cinemaList as $cinema) {
            echo "Name: ".$cinema->getName().'<br>';
            echo "Adress: ".$cinema->getAdress().'<br>';
            echo "OpeningTime: ".$cinema->getOpeningTime().'<br>';
            echo "ClosingTime: ".$cinema->getClosingTime().'<br>';
            echo "ticketValue: ".$cinema->getTicketValue().'<br>';
            echo "Id: ".$cinema->getId().'<br>';
            echo "----------------------".'<br>';
        }

        return $cinemaList;
    }

    public function GetCinema($cinemaSearched){

        $cinemaDAO= new CinemaDAO();
        $cinemas=$cinemaDAO->GetAll();


        foreach ($cinemas as $cinema) {
            
            
            if(strcmp($cinema->getName(),$cinemaSearched)==0){

                $cinemaFound= new Cinema();
                $cinemaFound=$cinema;
            }
        }
        if(empty($cinemaFound)){

            echo "Cinema ".$cinemaSearched." don't found";
        }else{
            //Muestro lo encontrado para probar, borrar cuando este la vista hecha.
            echo "Name:".$cinemaFound->getName().'<br>';
            echo "Adress".$cinemaFound->getAdress().'<br>';
            echo "OpeningTime".$cinemaFound->getOpeningTime().'<br>';
            echo "ClosingTime".$cinemaFound->getClosingTime().'<br>';
            echo "ticketValue".$cinemaFound->getTicketValue().'<br>';
            echo "Id".$cinemaFound->getId().'<br>';

        }
        return $cinemaFound;
    }

    public function Remove($cinemaToRemove)
    {
        $cinemaDAO= new CinemaDAO;
        $cinemaList=$cinemaDAO->Remove($cinemaToRemove);
    }

    public function Modify(Cinema $cinema)
    {
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
    }
}
?>




