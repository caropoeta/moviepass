<?php

namespace Controllers;

use DAO\RolesDAOjson;
use Models\UserModel as UserModel;
use Models\UserRole;

class HomeController
{
    public function Index($message = "")
    {
        HomeController::MainPage();
    }

    public static function MainPage()
    {
        SessionController::ValidateSession();

        if ($_SESSION['current_user'] instanceof UserModel)
            switch ($_SESSION['current_user']->getRole()) {
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
