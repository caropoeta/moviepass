<?php

namespace Controllers;

use DAO\CinemaDBDAO;
use DAO\GoogleQRDAO;
use DAO\MovieDAO;
use DAO\MoviesXFunctionsDAO;
use DAO\Session;
use DAO\TicketDAO;
use Exception;

class TicketController
{
    public function __construct()
    {
        if (!Session::ValidateSession()) {
            HomeController::MainPage();
            exit();
        }
    }

    public static function Index()
    {
        HomeController::MainPage();
    }

    public static function SelectFunction(int $movieId)
    {
        try {
            $data = TicketDAO::getFunctionsAndCinemasFromMovies($movieId);
        } catch (Exception $th) {
            ViewsController::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }
        $mov = MovieDAO::getMovieById($movieId);

        if ($mov != null)
            ViewsController::SelectFunction($data, $mov->getId(), $mov->getTitle(), Session::GetUserRole());
    }

    public static function ConfirmDetails(int $functionId)
    {
        try {
            $data = TicketDAO::getFunctionRoomAndCinemaDataFromFunctionId($functionId);
            $maxTickets = TicketDAO::getMaxAviableTicketsFromFunction($functionId);
        } catch (Exception $th) {
            ViewsController::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }
        $mov = MovieDAO::getMovieById($data['idMovie']);

        if ($mov != null)
            ViewsController::ConfirmDetails($data, $mov->getId(), $mov->getTitle(), Session::GetUserRole(), $maxTickets);
    }

    public static function Buy(int $numberOfTickets, int $functionId)
    {
        try {
            $data = TicketDAO::getFunctionRoomAndCinemaDataFromFunctionId($functionId);
            $maxTickets = TicketDAO::getMaxAviableTicketsFromFunction($functionId);
            if ($maxTickets <= $numberOfTickets)
                throw new Exception("Error Processing Request", 1);

            for ($i = 0; $i < $numberOfTickets; $i++)
                TicketDAO::addTicket($functionId, Session::GetUserId());


        } catch (Exception $th) {
            ViewsController::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }
        $mov = MovieDAO::getMovieById($data['idMovie']);

        $total = $data['price'] * $numberOfTickets;
        ViewsController::BuyResume($numberOfTickets, $data, $total, $mov->getId(), $mov->getTitle(), Session::GetUserRole());
    }

    public static function List ()
    {
        var_dump(TicketDAO::getTicketsFromUser(Session::GetUserId()));
        # code...
    }
}
