<?php

namespace DAO;

use Models\UserModel;

class Session
{
    public static function ValidateSession()
    {
        if (!isset($_SESSION['current_user']) || !$_SESSION['current_user'] instanceof UserModel)
            $_SESSION['current_user'] = null;

        return ($_SESSION['current_user']) ? true : false;
    }

    public static function GetCurrentUser()
    {
        if (Session::ValidateSession())
            return $_SESSION['current_user'];

        return null;
    }

    public static function SetSession($obj)
    {
        if ($obj != null && !($obj instanceof UserModel))
          $obj = null;

        $_SESSION['current_user'] = $obj;
    }

    public static function IsUserThisRole(String $role)
    {
        if (Session::ValidateSession()) {
            $currUsr = Session::GetCurrentUser();
            if ($currUsr instanceof UserModel)
                return (Session::GetCurrentUser()->getRole() == $role);
        }

        return false;
    }

    public static function GetUserId()
    {
        if (Session::ValidateSession()) {
            $currUsr = Session::GetCurrentUser();
            if ($currUsr instanceof UserModel)
                return $currUsr->getId();
        }

        return null;
    }

    public static function GetUserEmail()
    {
        if (Session::ValidateSession()) {
            $currUsr = Session::GetCurrentUser();
            if ($currUsr instanceof UserModel)
                return $currUsr->getEmail();
        }

        return null;
    }

    public static function GetUserRole()
    {
        if (Session::ValidateSession()) {
            $currUsr = Session::GetCurrentUser();
            if ($currUsr instanceof UserModel)
                return $currUsr->getRole();
        }

        return GUEST_ROLE_NAME;
    }
}
