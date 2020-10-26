<?php

namespace Controllers;

use DAO\MoviesXFunctionsDAO;
use DAO\RoomDBDAO;
use DAO\Session;

class FunctionsController
{
    public function __construct()
    {
        if (!Session::ValidateSession()) {
            HomeController::MainPage();
            exit();
        }
        if (!Session::IsUserThisRole('Admin')) {
            HomeController::MainPage();
            exit();
        }
    }

    public function Index()
    {
        HomeController::MainPage();
    }

    public function List($id)
    {
    }

    public function Add($id)
    {
    }

    public function Delete($id)
    {
    }

    public function Modify($id)
    {
    }
}
