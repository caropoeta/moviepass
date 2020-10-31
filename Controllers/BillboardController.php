<?php

namespace Controllers;


use DAO\GenreDAO;
use DAO\MoviesXFunctionsDAO;

use DAO\Session;
use Models\ViewsHandler;

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
        $genres = GenreDAO::getGenres();
        $movies = MoviesXFunctionsDAO::getMoviesFromFunctions($page, $name, $year, $genreW, $genreWO);

        $currRole = Session::GetUserRole();

        ViewsHandler::BillboardMovies($currRole, $movies, $genres, $currPage, $name, $genreW, $genreWO, $year);
    }
}
