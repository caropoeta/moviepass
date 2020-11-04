<?php

namespace Controllers;


use DAO\GenreDAO;
use DAO\MoviesXFunctionsDAO;

use DAO\Session;
use Controllers\ViewsController as ViewsHandler;
use Exception;

class BillboardController
{
    public function Index()
    {
        BillboardController::List();
    }

    public static function List(String $name = "", $genreW = [], $genreWO = [], $year = '0000', int $page = 1)
    {
        if ($page <= 0)
            $page = 1;

        if (!is_array($genreW))
            $genreW = [];

        if (!is_array($genreWO))
            $genreWO = [];

        $currPage = $page;
        try {
            $genres = GenreDAO::getGenres();
            $movies = MoviesXFunctionsDAO::getMoviesFromFunctions($page, $name, $year, $genreW, $genreWO);

            $currRole = Session::GetUserRole();

            $movHasFreeSeats = [];
            foreach ($movies as $value) {
                $movHasFreeSeats[$value->getId()] = MoviesXFunctionsDAO::checkAviableSeatsForMovie($value->getId());
            }
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        ViewsHandler::BillboardMovies($currRole, $movies, $genres, $currPage, $name, $genreW, $genreWO, $year, $movHasFreeSeats);
    }
}
