<?php

namespace Controllers;

use DAO\ApiDAO;
use DAO\GenereDAO;
use DAO\MovieDAO;
use DAO\UserDAO as UserDAO;
use Models\Movie;

class ApiController
{
    public function Index()
    {
        HomeController::MainPage();
    }

    public function List(int $id = 1)
    {
        if ($id <= 0) {
            $id = 1;
        }

        $currPage = $id;
        $generes = ApiDAO::getApiGeneres();
        $movies = ApiDAO::getApiMoviePage($id, $generes);
        require_once(VIEWS_PATH . 'apiMovies.php');
    }
}
