<?php

namespace Controllers;

use DAO\ApiMovieDAO;
use DAO\GenreDAO;
use DAO\MovieDAO;
use DAO\MovieXGenreDAO;
use DAO\Session;
use Controllers\ViewsController as ViewsHandler;
use DAO\TicketDAO;
use Exception;

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

    public static function GetMovieStatisics(int $idMov, String $strtPeriod = "", String $endPeriod = "")
    {
        try {
            $stats = TicketDAO::getStatisticsFromMovie($idMov, $strtPeriod, $endPeriod);
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }
        
        ViewsHandler::MovieStatistics($stats, $strtPeriod, $endPeriod, $idMov);
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
            $genres = GenreDAO::getGenres();
            $movies = MovieXGenreDAO::getMovies($page, $name, (int) $year, $genreW, $genreWO);
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        ViewsHandler::InternalMovies($name, $genreW, $genreWO, $year, $page, $genres, $movies);
    }

    public static function Delete($ids)
    {
        if (!is_array($ids))
            $ids = [];

        try {
            foreach ($ids as $value) {
                MovieDAO::deleteById($value);
            }
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        MoviesController::List();
    }

    public static function Add($ids)
    {
        if (!is_array($ids))
            $ids = [];

        try {
            foreach ($ids as $value) {
                $movieToAdd = ApiMovieDAO::getApiMovieById((int) $value);
                if ($movieToAdd != null)
                    MovieDAO::addMovie($movieToAdd);
            }
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        ApiController::List();
    }
}
