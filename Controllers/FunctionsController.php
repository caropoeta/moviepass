<?php

namespace Controllers;

use DAO\FunctionsDAO;
use DAO\MovieXGenreDAO;
use DAO\RoomDBDAO;
use DAO\Session;
use Models\Exceptions\ArrayException;
use Controllers\ViewsController as ViewsHandler;
use DAO\TicketDAO;
use Exception;

class FunctionsController
{
    public function __construct()
    {
        if (!Session::ValidateSession()) {
            HomeController::MainPage();
            exit();
        }
        if (!Session::IsUserThisRole(ADMIN_ROLE_NAME)) {
            HomeController::MainPage();
            exit();
        }
    }

    public static function Index()
    {
        HomeController::MainPage();
    }

    public static function List(int $roomId)
    {
        $cin = RoomDBDAO::getCinemaByRoomId($roomId);
        $opt = $cin->getopeningTime();
        $cst = $cin->getclosingTime();

        try {
            $functions = FunctionsDAO::getAllFromRoom($roomId);
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        ViewsHandler::FunctionList($opt, $cst, $roomId, $functions);
    }

    public static function Delete(int $id, int $roomid)
    {
        try {
            FunctionsDAO::delete($id);
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        FunctionsController::List($roomid);
    }

    public static function SelectMovieAdd(String $time, String $date, int $roomId, int $page = 1)
    {
        if ($page <= 0)
            $page = 1;

        try {
            $movies = MovieXGenreDAO::getMovies($page);
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        ViewsHandler::MovieSelectAddFunction($time, $date, $roomId, $page, $movies);
    }

    public static function SelectMovieUpdate(String $time, String $date, int $roomId, int $functionId, int $page = 1)
    {
        if ($page <= 0)
            $page = 1;

        try {
            $movies = MovieXGenreDAO::getMovies($page);
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        ViewsHandler::MovieSelectUpdateFunction($time, $date, $roomId, $functionId, $page, $movies);
    }

    public static function Update(String $time, String $date, int $roomId, int $functionId, int $movieId)
    {
        try {
            FunctionsDAO::update($time, $date, $roomId, $functionId, $movieId);
        } catch (ArrayException $EX) {
            ViewsHandler::Show($EX->getExceptionArray());
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        FunctionsController::List($roomId);
    }

    public static function Add(String $time, String $date, int $roomId, int $movieId)
    {
        try {
            FunctionsDAO::add($time, $date, $roomId, $movieId);
        } catch (ArrayException $EX) {
            ViewsHandler::Show($EX->getExceptionArray());
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        FunctionsController::List($roomId);
    }

    public static function GetFunctionStatistics(int $id)
    { 
        try {
            echo TicketDAO::getStatisticsFromFunction($id);
        } catch (Exception $th) {
            echo 'Error';
        }
    }
}
