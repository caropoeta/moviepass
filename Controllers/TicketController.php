<?php

namespace Controllers;

use DAO\CreditCardDAO;
use DAO\DiscountDAO;
use DAO\MovieDAO;
use DAO\Session;
use DAO\TicketDAO;
use DAO\UserXCreditCardDAO;
use Exception;
use Models\Exceptions\ArrayException;

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
            $mov = MovieDAO::getMovieById($data['idMovie']);
            $datDisArray = DiscountDAO::GetDiscountAndMinTicketsFromToday();
        } catch (Exception $th) {
            ViewsController::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        $discountMinTickets = $datDisArray['minTickets'];
        $discountPercentaje = $datDisArray['percentage'];

        if ($mov != null)
            ViewsController::ConfirmDetails(
                $data,
                $mov->getId(),
                $mov->getTitle(),
                Session::GetUserRole(),
                $maxTickets,
                $discountMinTickets,
                $discountPercentaje
            );
    }

    public static function DeleteCreditCard(
        int $numberOfTickets,
        int $functionId,
        int $creditCardNumber
    ) {
        try {
            UserXCreditCardDAO::delete($creditCardNumber, Session::GetUserId());
        } catch (Exception $th) {
            ViewsController::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        TicketController::SelectCreditCard($numberOfTickets, $functionId);
    }

    public static function SelectCreditCard(int $numberOfTickets, int $functionId)
    {
        try {
            $data = TicketDAO::getFunctionRoomAndCinemaDataFromFunctionId($functionId);
            $datDisArray = DiscountDAO::GetDiscountAndMinTicketsFromToday();
            $ccs = UserXCreditCardDAO::getCreditCardsFromUser(Session::GetUserId());
        } catch (Exception $th) {
            
            throw $th;
            ViewsController::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        $discountMinTickets = $datDisArray['minTickets'];
        $discountPercentaje = $datDisArray['percentage'];
        $price = $data['price'];

        if ($discountMinTickets <= $numberOfTickets)
            $price *= (1 - $discountPercentaje);

        $totalPrice = $price * $numberOfTickets;

        ViewsController::SelectCreditCard($numberOfTickets, $functionId, $ccs, $totalPrice, Session::GetUserRole());
    }

    public static function AddCreditCard(
        int $numberOfTickets,
        int $functionId,
        int $creditCardNumber,
        String $monthAndYear
    ) {     
        try {
            UserXCreditCardDAO::addCreditCardToUser(Session::GetUserId(), $creditCardNumber, $monthAndYear);
        } catch (ArrayException $aex) {
            ViewsController::Show($aex->getExceptionArray());
        }
        catch (Exception $th) {
            throw $th;
            ViewsController::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        TicketController::SelectCreditCard($numberOfTickets, $functionId);
    }

    public static function Buy(int $numberOfTickets, int $functionId, int $securityCode, int $creditCardId)
    {
        HomeController::MainPage();
        /*
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
    */}

    public static function List()
    {
        //var_dump(TicketDAO::getTicketsFromUser(Session::GetUserId()));
    }
}
