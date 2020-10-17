<?php

namespace Controllers;

use DAO\UserDAOjson as UserDAO;
use Models\PopupAlert;
use Models\UserModel as UserModel;
use Models\Exceptions\AddUserException;
use Models\Exceptions\UpdateUserException;
use Models\Exceptions\ValidateUserCredentialsException;
use DAO\Session;

class SessionController
{
    public function __construct()
    {
        Session::ValidateSession();
    }

    public function Edit(String $username, String $password, String $email, int $dni, String $birthday)
    {
        if (Session::ValidateSession()) {
            try {
                $currUSer = Session::GetCurrentUser();
                if ($currUSer instanceof UserModel) {
                    $currUSer->setName($username);
                    $currUSer->setPassword($password);
                    $currUSer->setEmail($email);
                    $currUSer->setDni($dni);
                    $currUSer->setBirthday($birthday);

                    UserDAO::updateUser($currUSer);
                }
            } catch (UpdateUserException $uue) {
                $alert = new PopupAlert($uue->getExceptionArray());
                $alert->Show();
            }
        }

        HomeController::MainPage();
    }

    public function Index(String $action = "")
    {
        switch ($action) {
            case 'register':
                if (Session::ValidateSession())
                    HomeController::MainPage();
                else
                    require_once(VIEWS_PATH . 'register.php');

                break;

            case 'login':
                if (Session::ValidateSession())
                    HomeController::MainPage();
                else
                    require_once(VIEWS_PATH . 'login.php');

                break;

            case 'edit':
                if (!Session::ValidateSession())
                    HomeController::MainPage();
                else if (Session::ValidateSession()) {
                    $currUSer = Session::GetCurrentUser();
                    $name = $currUSer->getName();
                    $password = $currUSer->getPassword();
                    $email = $currUSer->getEmail();
                    $dni = $currUSer->getDni();
                    $birthday = $currUSer->getBirthday();
                    $currUSer = null;

                    require_once(VIEWS_PATH . 'editUser.php');
                }

                break;

            default:
                HomeController::MainPage();
                break;
        }
    }

    public function Login(String $username, String $password)
    {
        try {
            if (!Session::ValidateSession()) {
                $logUser = UserDAO::validateUserCredentials($username, $password);
                if ($logUser instanceof UserModel)
                    Session::SetSession($logUser);
            }
        } catch (ValidateUserCredentialsException $vuce) {
            $alert = new PopupAlert($vuce->getExceptionArray());
            $alert->Show();
        }

        HomeController::MainPage();
    }

    public function Logout()
    {
        if (Session::ValidateSession())
            Session::SetSession(null);

        HomeController::MainPage();
    }

    public function Register(String $username, String $password, int $dni, String $email, String $birthday)
    {
        try {
            if (!Session::ValidateSession()) {
                $time = strtotime($birthday);
                $newformat = date('Y-m-d', $time);

                $newUser = new UserModel($username, $password, 'Client', $dni, $email, $newformat);
                $result = UserDAO::addUser($newUser);

                if ($result instanceof UserModel)
                    Session::SetSession(UserDAO::getUserByEmail($email));
            }
        } catch (AddUserException $adu) {
            $alert = new PopupAlert($adu->getExceptionArray());
            $alert->Show();
        }

        HomeController::MainPage();
    }
}
