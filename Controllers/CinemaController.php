<?php
namespace Controllers;

use DAO\CinemaDBDAO as CinemaDBDAO;
use Models\Cinema as Cinema;
use Models\Statistics as Statistics;
use Controllers\ViewsController as ViewsHandler;
use DAO\Session;
use DAO\TicketDAO;
use Models\Ticket;

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


    public function AddCinema($nameCinema, $address, $openingTime, $closingTime, $ticketValue, $capacity)
    {
        $cinemaDBDAO = new CinemaDBDAO();
        $cinemaList = $cinemaDBDAO->ReadAll();
        $idMax = 1;
        if ($cinemaList != false) {
            foreach ($cinemaList as $oneCinema) {

                if ($oneCinema->getidCinema() > $idMax) {
                    $idMax = $oneCinema->getidCinema();
                }
            }
        }
        $newId = $idMax + 1;
        $errorMessage = "";
        $hasError = false;
        if ($ticketValue <= 0) {
            $hasError = true;
            $errorMessage = $errorMessage . "The ticket value must be positive" . '\n';
        }
        if ($capacity <= 0) {
            $hasError = true;
            $errorMessage = $errorMessage . "The capacity value must be positive" . '\n';
        }
        if ($hasError == false) {
            $cinemaToAdd = new Cinema();
            $cinemaToAdd->setidCinema($newId);
            $cinemaToAdd->setnameCinema($nameCinema);
            $cinemaToAdd->setaddress($address);
            $cinemaToAdd->setopeningTime($openingTime);
            $cinemaToAdd->setclosingTime($closingTime);
            $cinemaToAdd->setticketValue($ticketValue);
            $cinemaToAdd->setcapacity($capacity);
            $cinemaToAdd->setdeleteCinema(false);

            $cinemaDBDAO->Add($cinemaToAdd);
            $cinemaList = $cinemaDBDAO->ReadAll();
        } else
            ViewsHandler::Show(["Error:", $errorMessage]);

        require_once(VIEWS_PATH . 'showCinemas.php');
    }

    public function ShowCinemas()
    {
        $CinemaDBDAO = new CinemaDBDAO();
        $cinemaList = $CinemaDBDAO->ReadAll();

        if ($cinemaList == null)
            ViewsHandler::Show(["Alert:", "There is no cinema entered"]);

        require_once(VIEWS_PATH . 'showCinemas.php');
    }

    public function ShowCinema($cinemaSearched)
    {
        $CinemaDBDAO = new CinemaDBDAO();
        $cinemas = $CinemaDBDAO->ReadAll();

        if (is_array($cinemas) || is_object($cinemas)) {
            foreach ($cinemas as $cinema) {
                if (strcmp($cinema->getnameCinema(), $cinemaSearched) == 0) {

                    $cinemaFound = $cinema;
                }
            }
        }
        require_once(VIEWS_PATH . 'showCinema.php');
    }

    public function DeleteCinema($deleteId)
    {
        $CinemaDBDAO = new CinemaDBDAO();
        $delete = $CinemaDBDAO->Remove($deleteId);
        if ($delete == true)
            ViewsHandler::Show(["Message:", "Cinema removed"]);

        require_once(VIEWS_PATH . 'indexCinema.php');
    }

    public function ModifyCinema($modifyId)
    {
        require_once(VIEWS_PATH . 'navbaradmin.php');
        $CinemaDBDAO = new CinemaDBDAO();
        $cinemaList = $CinemaDBDAO->ReadAll();
        $cinemaFound = new Cinema();

        foreach ($cinemaList as $oneCinema) {

            if ($modifyId == $oneCinema->getidCinema()) {

                $cinemaFound = $oneCinema;
            }
        }


        require_once(VIEWS_PATH . 'cinema.php');
    }

    public function UpdateCinema($idCinema, $nameCinema, $address, $openingTime, $closingTime, $ticketValue, $capacity)
    {
        $errorMessage = "";
        $hasError = false;
        if ($ticketValue <= 0) {
            $hasError = true;
            $errorMessage = $errorMessage . "The ticket value must be positive" . '\n';
        }
        if ($capacity <= 0) {
            $hasError = true;
            $errorMessage = $errorMessage . "The capacity value must be positive" . '\n';
        }
        if ($hasError == false) {

            $cinema = new Cinema();
            $cinema->setidCinema($idCinema);
            $cinema->setnameCinema($nameCinema);
            $cinema->setaddress($address);
            $cinema->setopeningTime($openingTime);
            $cinema->setclosingTime($closingTime);
            $cinema->setticketValue($ticketValue);
            $cinema->setcapacity($capacity);

            $CinemaDBDAO = new CinemaDBDAO();
            $CinemaDBDAO->Update($cinema);
        }

        require_once (VIEWS_PATH . 'indexCinema.php');
    }

    public function Statistics($cinemaId)
    {
        require_once (VIEWS_PATH . 'statistics.php');
    }

    public function ShowStatistics(String $startDate, String $finishDate, int $cinemaId)
    {
        $stats = TicketDAO::getStatisticsFromCinema($cinemaId, $startDate, $finishDate);
        require_once (VIEWS_PATH . 'showStatistics.php');
    }
}
