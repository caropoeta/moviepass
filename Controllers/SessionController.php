<?php

namespace Controllers;

use DAO\UsersDAO as UserDAO;
use Models\PopupAlert;
use Models\UserModel as UserModel;
use Models\Exceptions\AddUserException;
use Models\Exceptions\UpdateUserException;
use Models\Exceptions\ValidateUserCredentialsException;
use DAO\Session;
use Controllers\ViewsController as ViewsHandler;
use Exception;

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
                    $nwuser = new UserModel(
                        $username,
                        $password,
                        $currUSer->getRole(),
                        $dni,
                        $email,
                        $birthday,
                        $currUSer->getId()
                    );

                    $response = UserDAO::updateUser($nwuser);

                    if ($response instanceof UserModel)
                        Session::SetSession($response);
                }
            } catch (UpdateUserException $uue) {
                ViewsHandler::Show($uue->getExceptionArray());
            } catch (Exception $th) {
                ViewsHandler::Show(array('Error processing request'));
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
                    ViewsHandler::Register();

                break;

            case 'login':
                if (Session::ValidateSession())
                    HomeController::MainPage();
                else
                    ViewsHandler::Login();

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

                    ViewsHandler::EditUser($name, $password, $email, $dni, $birthday);
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
            ViewsHandler::Show($vuce->getExceptionArray());
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
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

                $newUser = new UserModel($username, $password, CLIENT_ROLE_NAME, $dni, $email, $newformat);
                $result = UserDAO::addUser($newUser);

                if ($result instanceof UserModel)
                    Session::SetSession(UserDAO::getUserByEmail($email));
            }
        } catch (AddUserException $adu) {
            ViewsHandler::Show($adu->getExceptionArray());
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
        }

        HomeController::MainPage();
    }
}
