<?php

namespace Controllers;

use DAO\ApiGenreDAO;
use DAO\ApiMovieDAO;
use DAO\GenreDAO;
use DAO\MovieDAO;
use DAO\MovieXGenreDAO;
use Models\Genre;
use Models\Movie;

class ApiController
{
    public static function Index()
    {
        HomeController::MainPage();
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
        $currMovies = MovieXGenreDAO::getMovies();
        $genres = ApiGenreDAO::getApiGenres();

        $year = (int) 2020;

        if ($name == "" && $year == 0 && empty($genreW) && empty($genreWO)) {
            $movies = ApiMovieDAO::getApiMoviePage($page);
        } else if ($name != "")
            $movies = ApiMovieDAO::getApiMovieSearchByName($page, $name);

        else
            $movies = ApiMovieDAO::getApiMovieSearchByDateAndGenre($page, (int) $year, $genreW, $genreWO);

        require_once(VIEWS_PATH . 'apiMovies.php');
    }
}
