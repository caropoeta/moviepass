<?php

namespace Controllers;

use DAO\UserDAOjson as UserDAO;
use Models\PopupAlert;
use Models\UserModel as UserModel;
use Models\Exceptions\AddUserException;
use Models\Exceptions\UpdateUserException;
use Models\Exceptions\ValidateUserCredentialsException;

class SessionController
{
    private function Edit() {
        try {
            //code...
        } catch (UpdateUserException $uue) {
            $alert = new PopupAlert($uue->getExceptionArray());
            $alert->Show();
        }
    }

    public function __construct()
    {
        SessionController::ValidateSession();
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
        if (SessionController::ValidateSession()) {
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
        try {
            if (!SessionController::ValidateSession()) {
                $logUser = UserDAO::validateUserCredentials($username, $password);
                if ($logUser instanceof UserModel)
                    SessionController::SetSession($logUser);
            }
        } catch (ValidateUserCredentialsException $vuce) {
            $alert = new PopupAlert($vuce->getExceptionArray());
            $alert->Show();
        }

        HomeController::MainPage();
    }

    public function Logout()
    {
        if (SessionController::ValidateSession())
            SessionController::SetSession(null);

        HomeController::MainPage();
    }

    public function Register(String $username, String $password, int $dni, String $email, String $birthday)
    {
        try {
            if (!SessionController::ValidateSession()) {
                $time = strtotime($birthday);
                $newformat = date('Y-m-d', $time);

                $newUser = new UserModel($username, $password, 'Client', $dni, $email, $newformat);
                $result = UserDAO::addUser($newUser);

                if ($result instanceof UserModel)
                    SessionController::SetSession(UserDAO::getUserByEmail($email));
            }
        } catch (AddUserException $adu) {
            $alert = new PopupAlert($adu->getExceptionArray());
            $alert->Show();
        }

        HomeController::MainPage();
    }
}
