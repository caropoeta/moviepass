<?php

namespace Controllers;

use DAO\Session;
use Controllers\ViewsController as ViewsHandler;

class HomeController
{
    public function Index($message = "")
    {
        HomeController::MainPage();
    }

    public static function MainPage()
    {
        if (Session::GetUserRole() == GUEST_ROLE_NAME) {
            ViewsHandler::Main();
            return;
        }

        BillboardController::List();
    }
}
