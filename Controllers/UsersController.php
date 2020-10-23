<?php

namespace Controllers;

use DAO\RolesDAO as RolesDAO;
use DAO\UsersDAO as UserDAO;
use Models\Exceptions\AddUserException;
use Models\Exceptions\UpdateUserException;
use Models\PopupAlert;
use DAO\Session;

use Models\UserModel as UserModel;

class UsersController
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

    public function Add(String $username, String $password, String $email, int $dni, String $birthday, String $role)
    {
        try {
            $time = strtotime($birthday);
            $newformat = date('Y-m-d', $time);

            UserDAO::addUser(new UserModel($username, $password, $role, $dni, $email, $newformat));
        } catch (AddUserException $aue) {
            $alert = new PopupAlert($aue->getExceptionArray());
            $alert->Show();
        }

        $roles = RolesDAO::getRoles();
        $users = UserDAO::getUsers();
        require_once(VIEWS_PATH . 'usersList.php');
    }

    public function Index()
    {
        $this->List();
    }

    public function List(String $name = "", String $email = "", String $dni = "", String $role = "")
    {
        var_dump($role);
        $roles = RolesDAO::getRoles();
        $users = UserDAO::getUsers($name, $email, $dni, $role);
        require_once(VIEWS_PATH . 'usersList.php');
    }

    public function Edit(String $email, int $dni, String $birthday, String $role, int $id)
    {
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
            $alert = new PopupAlert($uue->getExceptionArray());
            $alert->Show();
        }

        $roles = RolesDAO::getRoles();
        $users = UserDAO::getUsers();
        require_once(VIEWS_PATH . 'usersList.php');
    }

    public function Delete(int $id)
    {
        if (Session::ValidateSession() && $id != Session::GetUserId())
            UserDAO::deleteUser($id);

        $roles = RolesDAO::getRoles();
        $users = UserDAO::getUsers();
        require_once(VIEWS_PATH . 'usersList.php');
    }
}
