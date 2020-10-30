<?php

namespace Controllers;


use DAO\GenreDAO;
use DAO\MoviesXFunctionsDAO;

use DAO\Session;

class BillboardController
{
    public function Index()
    {
        HomeController::MainPage();
    }


    public function List(String $name = "", $genreW = [], $genreWO = [], $year = '0000', int $page = 1)
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
        
        require_once(VIEWS_PATH . 'billboardMovies.php');
    }

}
