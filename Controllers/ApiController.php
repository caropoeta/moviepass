<?php

namespace Controllers;

use DAO\ApiDAO;

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
        $genres = ApiDAO::getApiGenres();
        $movies = ApiDAO::getApiMoviePage($id, $genres);
        require_once(VIEWS_PATH . 'apiMovies.php');
    }
}
