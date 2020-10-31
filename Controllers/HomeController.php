<?php

namespace Controllers;

use DAO\Session;
use Models\ViewsHandler;

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
                    ViewsHandler::Main();
                    return;
            }

        ViewsHandler::Main();
        return;
    }
}
