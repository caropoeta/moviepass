<?php

namespace Controllers;

use DAO\Session;
use DAO\UsersDAO as UsersDAO;

class HomeController
{
    public function Index($message = "")
    {
        HomeController::MainPage();
    }

    public static function MainPage()
    {
        if (Session::ValidateSession())
            switch (Session::GetUserRole()) {
                case 'Admin':
                    require_once(VIEWS_PATH . 'adminMenu.php');
                    return;

                case 'Client':
                    require_once(VIEWS_PATH . 'clientMenu.php');
                    return;

                default:
                    require_once(VIEWS_PATH . 'main.php');
                    return;
            }

        require_once(VIEWS_PATH . 'main.php');
        return;
    }
}
