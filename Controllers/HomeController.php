<?php

namespace Controllers;

use DAO\Session;

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
                case ADMIN_ROLE_NAME:
                    BillboardController::List();
                    return;

                case CLIENT_ROLE_NAME:
                    BillboardController::List();
                    return;

                case GUEST_ROLE_NAME:
                    BillboardController::List();
                    return;

                default:
                    require_once(VIEWS_PATH . 'main.php');
                    return;
            }

        require_once(VIEWS_PATH . 'main.php');
        return;
    }
}
