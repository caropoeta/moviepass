<?php

namespace Controllers;

use DAO\UserDAO as UserDAO;
use Models\UserModel as UserModel;

class LogController
{
    public function __construct()
    {
        LogController::ValidateSession();
    }

    public static function ValidateSession()
    {
        if (!isset($_SESSION['current_user']))
            $_SESSION['current_user'] = null;

        return ($_SESSION['current_user'] instanceof UserModel) ? true : false;
    }

    public static function SetSession($obj)
    {
        $_SESSION['current_user'] = $obj;
    }

    public function Index(String $action = "")
    {
        if (LogController::ValidateSession()) {
            HomeController::MainPage();
            return;
        }

        switch ($action) {
            case 'register':
                require_once(VIEWS_PATH . 'register.php');
                return;

            case 'login':
                require_once(VIEWS_PATH . 'login.php');
                return;

            default:
                HomeController::MainPage();
                return;
        }
    }

    public function Login(String $username, String $password)
    {
        if (!LogController::ValidateSession()) {
            $logUser = UserDAO::validateUserCredentials($username, $password);
            if ($logUser instanceof UserModel)
                LogController::SetSession($logUser);
        }

        HomeController::MainPage();
    }

    public function Logout()
    {
        if (LogController::ValidateSession())
            LogController::SetSession(null);

        HomeController::MainPage();
    }

    public function Register(String $username, String $password, int $dni, String $email, String $birthday)
    {
        if (!LogController::ValidateSession()) {
            $time = strtotime($birthday);
            $newformat = date('Y-m-d', $time);

            $newUser = new UserModel($username, $password, 'Client', $dni, $email, $newformat);
            $result = UserDAO::addUser($newUser);

            if ($result instanceof UserModel)
                LogController::SetSession(UserDAO::getUserByEmail($email));
        }
        HomeController::MainPage();
    }
}
