<?php

namespace Controllers;

use DAO\ApiGenreDAO;
use DAO\ApiMovieDAO;
use DAO\MovieDAO;
use DAO\Session;
use Controllers\ViewsController as ViewsHandler;
use Exception;

class ApiController
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

        try {
            $genres = ApiGenreDAO::getApiGenres();

            if ($name == "" && $year == '0000' && empty($genreW) && empty($genreWO)) {
                $movies = ApiMovieDAO::getApiMoviePage($page);
            } else if ($name != "")
                $movies = ApiMovieDAO::getApiMovieSearchByName($page, $name);

            else
                $movies = ApiMovieDAO::getApiMovieSearchByDateAndGenre($page, (int) $year, $genreW, $genreWO);

            $currMov = [];
            foreach ($movies as $movie) {
                $currMov[$movie->getId()] = MovieDAO::checkMovieById($movie->getId());
            }
        } catch (Exception $l) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        ViewsHandler::ApiMovies($currMov, $movies, $genres, $page, $name, $genreW, $genreWO, $year);
    }
}
