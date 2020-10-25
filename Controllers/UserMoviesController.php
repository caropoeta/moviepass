<?php

namespace Controllers;

use DAO\Session;

class UserMoviesController
{
    public function __construct()
    {
        if (!Session::ValidateSession()) {
            HomeController::MainPage();
            exit();
        }
    }

    public function Index()
    {
        HomeController::MainPage();
    }

    public function List() {}
}
