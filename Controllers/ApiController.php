<?php

namespace Controllers;

use DAO\UserDAO as UserDAO;

class ApiController
{
    public function Index()
    {
        HomeController::MainPage();
    }

    public function List()
    {
        //$roles = UserDAO::getRoles();
        //$users = UserDAO::getUsers(); conseguir peliculas 
        $movies = UserDAO::getUsers();;
        require_once(VIEWS_PATH . 'apiMovies.php');
    }
}
