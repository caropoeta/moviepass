<?php

namespace Controllers;

use Models\UserModel as UserModel;

class HomeController
{
    public function Index($message = "")
    {
        require_once(VIEWS_PATH . "main.php");
    }

    public static function MainPage()
    {
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
