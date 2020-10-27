<?php

namespace Controllers;

use DAO\FunctionsDAO;
use DAO\MovieXGenreDAO;
use DAO\Session;

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
        $functions = FunctionsDAO::getAllFromRoom($roomId);
        require_once(VIEWS_PATH . 'functionList.php');
    }

    public static function Delete(int $id, int $roomid)
    {
        FunctionsDAO::delete($id);
        FunctionsController::List($roomid);
    }

    public static function SelectMovieAdd(String $time, int $roomId, int $functionId, int $page = 1)
    {
        if ($page <= 0)
            $page = 1;

        $movies = MovieXGenreDAO::getMovies($page);
        require_once(VIEWS_PATH . 'movieSelectAddFunction.php');
    }

    public static function SelectMovieUpdate(String $time, int $roomId, int $functionId, int $page = 1)
    {
        if ($page <= 0)
            $page = 1;

        $movies = MovieXGenreDAO::getMovies($page);
        require_once(VIEWS_PATH . 'movieSelectUpdateFunction.php');
    }

    public static function Update(String $time, int $roomId, int $functionId, int $movieId)
    {
        //FunctionsDAO::update($id);
        FunctionsController::List($roomId);
    }

    public static function Add(String $time, int $roomId, int $functionId, int $movieId)
    {
        //FunctionsDAO::add($id);
        FunctionsController::List($roomId);
    }
}
