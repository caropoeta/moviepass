<?php

namespace Controllers;

use DAO\FunctionsDAO;
use DAO\MovieXGenreDAO;
use DAO\RoomDBDAO;
use DAO\Session;
use Models\Exceptions\ArrayException;
use Models\PopupAlert;

class FunctionsController
{
    public function __construct()
    {
        if (!Session::ValidateSession()) {
            HomeController::MainPage();
            exit();
        }
        if (!Session::IsUserThisRole('Admin')) {
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
        $functions = FunctionsDAO::getAllFromRoom($roomId);
        require_once(VIEWS_PATH . 'functionList.php');
    }

    public static function Delete(int $id, int $roomid)
    {
        FunctionsDAO::delete($id);
        FunctionsController::List($roomid);
    }

    public static function SelectMovieAdd(String $time, String $date, int $roomId, int $page = 1)
    {
        if ($page <= 0)
            $page = 1;

        $movies = MovieXGenreDAO::getMovies($page);
        require_once(VIEWS_PATH . 'movieSelectAddFunction.php');
    }

    public static function SelectMovieUpdate(String $time, String $date, int $roomId, int $functionId, int $page = 1)
    {
        if ($page <= 0)
            $page = 1;

        $movies = MovieXGenreDAO::getMovies($page);
        require_once(VIEWS_PATH . 'movieSelectUpdateFunction.php');
    }

    public static function Update(String $time, String $date, int $roomId, int $functionId, int $movieId)
    {
        try {
            FunctionsDAO::update($time, $date, $roomId, $functionId, $movieId);
        } catch (ArrayException $EX) {
            $alert = new PopupAlert($EX->getExceptionArray());
            $alert->Show();
        }

        FunctionsController::List($roomId);
    }

    public static function Add(String $time, String $date, int $roomId, int $movieId)
    {
        try {
            FunctionsDAO::add($time, $date, $roomId, $movieId);
        } catch (ArrayException $EX) {
            $alert = new PopupAlert($EX->getExceptionArray());
            $alert->Show();
        }

        FunctionsController::List($roomId);
    }
}
