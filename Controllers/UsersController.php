<?php

namespace Controllers;

use DAO\UserDAOjson as UserDAO;
use Models\UserModel as UserModel;

class UsersController
{
    public function __construct()
    {
        if (
            !$_SESSION['current_user'] ||
            !($_SESSION['current_user'] instanceof UserModel)
        ) {
            HomeController::MainPage();
            exit();
        }
        if ($_SESSION['current_user']->getRole() != 'Admin') {
            HomeController::MainPage();
            exit();
        }
    }

    public function Add(String $username, String $password, String $email, int $dni, String $birthday, String $role)
    {
        $time = strtotime($birthday);
        $newformat = date('Y-m-d', $time);

        UserDAO::addUser(new UserModel($username, $password, $role, $dni, $email, $newformat));

        $roles = UserDAO::getRoles();
        $users = UserDAO::getUsers();
        require_once(VIEWS_PATH . 'usersList.php');
    }

    public function Index()
    {
        $this->List();
    }

    public function List()
    {
        $roles = UserDAO::getRoles();
        $users = UserDAO::getUsers();
        require_once(VIEWS_PATH . 'usersList.php');
    }

    public function Edit(String $email, int $dni, String $birthday, String $role, int $id)
    {
        if ($id != $_SESSION['current_user']->getId()) {
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

        $roles = UserDAO::getRoles();
        $users = UserDAO::getUsers();
        require_once(VIEWS_PATH . 'usersList.php');
    }

    public function Delete(int $id)
    {
        if ($id != $_SESSION['current_user']->getId())
            UserDAO::deleteUser($id);

        $roles = UserDAO::getRoles();
        $users = UserDAO::getUsers();
        require_once(VIEWS_PATH . 'usersList.php');
    }
}