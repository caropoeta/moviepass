<?php

namespace Controllers;

use DAO\ApiMovieDAO;
use DAO\GenreDAO;
use DAO\MovieDAO;
use DAO\MovieXGenreDAO;
use DAO\Session;

class MoviesController
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
        $movies = MovieXGenreDAO::getMovies($page, $name, (int) $year, $genreW, $genreWO);

        require_once(VIEWS_PATH . 'internalMovies.php');
    }

    public static function Delete($ids)
    {
        if (!is_array($ids))
            $ids = [];

        foreach ($ids as $value) {
            MovieDAO::deleteById($value);
        }

        MoviesController::List();
    }

    public static function Add($ids)
    {
        if (!is_array($ids))
            $ids = [];

        foreach ($ids as $value) {
            $movieToAdd = ApiMovieDAO::getApiMovieById((int) $value);
            if ($movieToAdd != null)
                MovieDAO::addMovie($movieToAdd);
        }

        ApiController::List();
    }
}
