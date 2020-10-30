<?php

namespace Controllers;

use DAO\FacebookDAO;
use \Models\UserModel as UserModel;
use \DAO\UsersDAO as UserDAO;
use Models\Exceptions\AddUserException;
use Models\PopupAlert;
use DAO\Session;
use DAO\UsersDAO;
use Models\Exceptions\ValidateUserCredentialsException;

class FacebookSessionController
{
    public static function Register(String $username, String $password, int $dni, String $birthday, String $email)
    {
        try {
            if (!Session::ValidateSession()) {
                $time = strtotime($birthday);
                $newformat = date('Y-m-d', $time);

                $newUser = new UserModel($username, $password, 'Client', $dni, $email, $newformat);
                $result = UserDAO::addUser($newUser);

                if ($result instanceof UserModel) {
                    Session::SetSession(UserDAO::getUserByEmail($email));
                }
            }
        } catch (AddUserException $adu) {
            $alert = new PopupAlert($adu->getExceptionArray());
            $alert->Show();
        }

        HomeController::MainPage();
    }

    public function Index()
    {
        if (Session::ValidateSession()) {
            HomeController::MainPage();
            exit;
        }

        header('Location: ' . FacebookDAO::GetInstance()->GetLoginUrl(
            'http://' . $_SERVER['HTTP_HOST'] . '/personal/moviepass/FacebookSession/Login/'
        ));
    }

    public function Login()
    {
        if (Session::ValidateSession()) {
            HomeController::MainPage();
            exit;
        }

        $fbUser = FacebookDAO::GetInstance()->GetUserData();

        if (UsersDAO::isUserDeletedByEmail($fbUser['email'])) {
            $alert = new PopupAlert(array('This account is banned'));
            $alert->Show();

            HomeController::MainPage();
            return;
        }

        $usr = UserDAO::getUserByEmail($fbUser['email']);

        if ($usr instanceof UserModel) {
            Session::SetSession($usr);
            HomeController::MainPage();
        } else {
            $fbname = $fbUser['first_name'] . ' ' .  $fbUser['last_name'];
            $fbemail = $fbUser['email'];
            require_once(VIEWS_PATH . 'facebookLoginAddUser.php');
        }
    }
}
