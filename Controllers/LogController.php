<?php

namespace Controllers;

use DAO\UserDAO as UserDAO;
use Models\UserModel as UserModel;

class LogController
{
    public function __construct()
    {
        if (!isset($_SESSION['current_user']))
            $_SESSION['current_user'] = null;
    }

    public function Index(String $action = "")
    {
        if ($_SESSION['current_user']) {
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
        if (!$_SESSION['current_user']) {
            $logUser = UserDAO::validateUserCredentials($username, $password);
            if ($logUser instanceof UserModel) {
                $_SESSION['current_user'] = $logUser;
            }
        }
        
        HomeController::MainPage();
    }

    public function Logout()
    {
        if ($_SESSION['current_user'])
            $_SESSION['current_user'] = null;

        HomeController::MainPage();
    }

    public function FacebookLogin()
    {
        require_once(VIEWS_PATH . 'facebookLoginAddUser.php');
    }

    public function Register(String $username, String $password, int $dni, String $email, String $birthday)
    {
        if (!$_SESSION['current_user']) {
            $time = strtotime($birthday);
            $newformat = date('Y-m-d',$time);

            $newUser = new UserModel($username, $password, 'Client', $dni, $email, $newformat);
            $result = UserDAO::addUser($newUser);

            if ($result instanceof UserModel) {
                $_SESSION['current_user'] = UserDAO::getUserByEmail($email);
            }
        }
        HomeController::MainPage();
    }
}
