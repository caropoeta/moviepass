<?php

namespace Controllers;

abstract class ViewsController
{
    public static function Show(array $alerts = [], Bool $usesKey = false)
    {
        echo '<script>alert("';

        if (!$usesKey) {
            foreach ($alerts as $value) {
                echo $value . '\n';
            }
        } else {
            foreach ($alerts as $key => $value) {
                echo $key . ' ' . $value . '\n';
            }
        }

        echo '")</script>';
    }

    public static function ApiMovies(
        array $currMov,
        array $movies,
        array $genres,
        int $currPage,
        String $name,
        array $genreW,
        array $genreWO,
        string $year
    ) {
        require_once(VIEWS_PATH . 'apiMovies.php');
    }

    public static function BillboardMovies(
        String $currRole,
        array $movies,
        array $genres,
        int $currPage,
        String $name,
        array $genreW,
        array $genreWO,
        string $year
    ) {
        require_once(VIEWS_PATH . 'billboardMovies.php');
    }

    public static function FacebookLoginAddUser(
        String $fbname,
        string $fbemail
    ) {
        require_once(VIEWS_PATH . 'facebookLoginAddUser.php');
    }

    public static function FunctionList(
        String $opt,
        string $cst,
        int $roomId,
        array $functions
    ) {
        require_once(VIEWS_PATH . 'functionList.php');
    }

    public static function MovieSelectAddFunction(
        String $time,
        String $date,
        int $roomId,
        int $page,
        array $movies
    ) {
        require_once(VIEWS_PATH . 'movieSelectAddFunction.php');
    }

    public static function MovieSelectUpdateFunction(
        String $time,
        String $date,
        int $roomId,
        int $functionId,
        int $page,
        array $movies
    ) {
        require_once(VIEWS_PATH . 'movieSelectUpdateFunction.php');
    }

    public static function Main()
    {
        require_once(VIEWS_PATH . 'main.php');
    }

    public static function InternalMovies(
        String $name,
        array $genreW,
        array $genreWO,
        String $year,
        int $currPage,
        array $genres,
        array $movies
    ) {
        require_once(VIEWS_PATH . 'internalMovies.php');
    }

    public static function Register()
    {
        require_once(VIEWS_PATH . 'register.php');
    }

    public static function Login()
    {
        require_once(VIEWS_PATH . 'login.php');
    }

    public static function EditUser(
        String $name,
        String $password,
        String $email,
        int $dni,
        String $birthday
    ) {
        require_once(VIEWS_PATH . 'editUser.php');
    }

    public static function UsersList(
        array $roles,
        array $users
    ) {
        require_once(VIEWS_PATH . 'usersList.php');
    }
}
