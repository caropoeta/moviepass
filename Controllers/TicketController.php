<?php

namespace Controllers;

use DAO\DiscountDAO;
use DAO\MailDAO;
use DAO\MovieDAO;
use DAO\PurchaseDAO;
use DAO\Session;
use DAO\TicketDAO;
use DAO\UserXCreditCardDAO;
use Exception;
use Models\Exceptions\ArrayException;
use Models\Ticket;

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
        } catch (Exception $th) {
            ViewsController::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        TicketController::SelectCreditCard($numberOfTickets, $functionId);
    }

    public static function GetAuthorization(int $numberOfTickets, int $functionId, int $securityCode, int $creditCardNumber)
    {
        sleep(5);
        ViewsController::Show(array('Recived authorization'));
        TicketController::Buy($numberOfTickets, $functionId, $creditCardNumber);
    }

    public static function Buy(int $numberOfTickets, int $functionId, int $creditCardNumber)
    {
        try {
            $discountId = (DiscountDAO::GetDiscountAndMinTicketsFromToday()['percentage'] == 0) ?
                DiscountDAO::GetDiscountIdForNoDiscount() : DiscountDAO::GetDiscountIdForToday();

            $lstLastPurchaseId = PurchaseDAO::addPurchase(
                $numberOfTickets,
                $functionId,
                $creditCardNumber,
                $discountId,
                Session::GetUserId()
            );

            for ($i = 0; $i < $numberOfTickets; $i++) {
                TicketDAO::addTicket(
                    $functionId,
                    Session::GetUserId(),
                    $lstLastPurchaseId
                );
            }

            $tickets = TicketDAO::getTicketsFromUserPurchase(Session::GetUserId(), $lstLastPurchaseId);

            MailDAO::sendMail(
                Session::GetUserEmail(),
                "Buying tickets at " . HOST_NAME,
                ViewsController::GetTicketsMailMessage(HOST_NAME, $tickets)
            );
        } catch (Exception $th) {
            ViewsController::Show(array('Error processing request'));
        }

        HomeController::MainPage();
    }

    public static function List(String $movieName = "", String $date = "", String $orderby = "none")
    {
        try {
            $tickets = TicketDAO::getTicketsFromUser(Session::GetUserId(), $movieName, $date, $orderby);
        } catch (Exception $th) {
            ViewsController::Show(array('Error processing request'));
        }

        ViewsController::TicketList($tickets, $movieName, $date, Session::GetUserRole(), $orderby);
    }
}
