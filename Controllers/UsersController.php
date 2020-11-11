<?php

namespace Controllers;

use DAO\RolesDAO as RolesDAO;
use DAO\UsersDAO as UserDAO;
use Models\Exceptions\AddUserException;
use Models\Exceptions\UpdateUserException;
use DAO\Session;

use Models\UserModel as UserModel;
use Controllers\ViewsController as ViewsHandler;
use Exception;

class UsersController
{
    public function __construct()
    {
        if (!Session::ValidateSession()) {
            HomeController::MainPage();
            exit();
        }
        if (!Session::IsUserThisRole(ADMIN_ROLE_NAME)) {
            HomeController::MainPage();
            exit();
        }
    }

    public static function Add(String $username, String $password, String $email, int $dni, String $birthday, String $role)
    {
        try {
            $time = strtotime($birthday);
            $newformat = date('Y-m-d', $time);

            UserDAO::addUser(new UserModel($username, $password, $role, $dni, $email, $newformat));
        } catch (AddUserException $aue) {
            ViewsHandler::Show($aue->getExceptionArray());
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        UsersController::List();
    }

    public static function Index()
    {
        UsersController::List();
    }

    public static function List(String $name = "", String $email = "", String $dni = "", String $role = "")
    {
        try {
            $role = ($role = RolesDAO::getRoleByName($role)) ? $role->getId() : '';
            $users = UserDAO::getUsers($name, $email, $dni, $role);
            $roles = RolesDAO::getRoles();
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        ViewsHandler::UsersList($roles, $users);
    }

    public static function Edit(String $email, int $dni, String $birthday, String $role, int $id)
    {

        var_dump($email,  $dni,  $birthday,  $role,  $id);
        try {
            if (Session::ValidateSession() && $id != Session::GetUserId()) {
                $user = UserDAO::getUserById($id);

                if ($user instanceof UserModel) {
                    $time = strtotime($birthday);
                    $newformat = date('Y-m-d', $time);

                    $user->setEmail($email);
                    $user->setDni($dni);
                    $user->setBirthday($newformat);
                    $user->setRole($role);

                    UserDAO::updateUser($user);
                }
            }
        } catch (UpdateUserException $uue) {
            ViewsHandler::Show($uue->getExceptionArray());
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        UsersController::List();
    }

    public static function Delete(int $id)
    {
        try {
            if (Session::ValidateSession() && $id != Session::GetUserId())
                UserDAO::deleteUser($id);
        } catch (Exception $th) {
            ViewsHandler::Show(array('Error processing request'));
            HomeController::MainPage();
            exit;
        }

        UsersController::List();
    }
}
