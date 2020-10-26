<?php

namespace Controllers;

use DAO\FunctionsDAO;
use DAO\MoviesXFunctionsDAO;
use DAO\RoomDBDAO;
use DAO\Session;
use Models\Functions;

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

    public static function Index()
    {
        HomeController::MainPage();
    }

    public static function List(int $roomId)
    {
        $functions = FunctionsDAO::getAllFromRoom($roomId);
        require_once(VIEWS_PATH . 'functionList.php');
    }

    public static function Add(int $roomid)
    {
        //FunctionsDAO::add($id);
        FunctionsController::List($roomid);
    }

    public static function Delete(int $id, int $roomid)
    {
        FunctionsDAO::delete($id);
        FunctionsController::List($roomid);
    }

    public static function Modify(int $roomid)
    {
        //FunctionsDAO::delete($id);
        FunctionsController::List($roomid);
    }
}
