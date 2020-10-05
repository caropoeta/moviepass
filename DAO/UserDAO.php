<?php

namespace DAO;

use DAO\DBConection as DBConection;
use Models\UserModel as UserModel;
use Models\UserRole as UserRole;

class UserDAO
{
    private static function isThisStringValid(String $string)
    {
        return (trim($string)) ? true : false;
    }

    public static function existsUsername(String $username)
    {
        if (!UserDAO::isThisUsernameValid($username))
            return false;

        $conection = DBConection::getDBConnection();
        $result = mysqli_query($conection, "SELECT 1 FROM users WHERE user_name = '" . $username . "'");
        mysqli_close($conection);

        return ($result && mysqli_num_rows($result) > 0) ? true : false;
    }

    public static function existsEmail(String $obj)
    {
        $conection = DBConection::getDBConnection();
        $result = mysqli_query($conection, "SELECT 1 FROM users WHERE user_email = '" . $obj . "'");
        mysqli_close($conection);

        return ($result && mysqli_num_rows($result) > 0) ? true : false;
    }

    public static function existsDni(int $obj)
    {
        $conection = DBConection::getDBConnection();
        $result = mysqli_query($conection, "SELECT 1 FROM users WHERE user_dni = " . $obj);
        mysqli_close($conection);

        return ($result && mysqli_num_rows($result) > 0) ? true : false;
    }

    public static function isThisPasswordValid(String $password)
    {
        return UserDAO::isThisStringValid($password);
    }

    public static function isThisUsernameValid(String $password)
    {
        return UserDAO::isThisStringValid($password);
    }

    public static function validateUserCredentials(String $username, String $password)
    {
        if (!UserDAO::isThisUsernameValid($username) || !UserDAO::isThisPasswordValid($password))
            return false;

        $conection = DBConection::getDBConnection();
        $result = mysqli_query($conection, "SELECT user_password FROM users WHERE user_name = '" . $username . "'");
        mysqli_close($conection);

        if ($result &&  mysqli_num_rows($result) > 0) {
            if (password_verify($password, mysqli_fetch_assoc($result)["user_password"])) {
                $conection = DBConection::getDBConnection();
                $result = mysqli_query(
                    $conection,
                    "SELECT user_id,user_dni,user_email,user_birthday,role_name
                    FROM users 
                    INNER JOIN roles
                    ON roles.role_id=users.user_role
                    WHERE user_name = '" . $username . "'"
                );
                mysqli_close($conection);

                $responseArray = mysqli_fetch_assoc($result);
                $validatedUser = new UserModel(
                    (string)    $username,
                    (string)    $password,
                    (string)    $responseArray["role_name"],
                    (int)       $responseArray["user_dni"],
                    (string)    $responseArray["user_email"],
                    (string)    $responseArray["user_birthday"],
                    (int)       $responseArray["user_id"]
                );

                return $validatedUser;
            }
        } else
            return false;
    }

    public static function getUsers()
    {
        $conection = DBConection::getDBConnection();
        $userResult = mysqli_query(
            $conection,
            "SELECT * FROM users
            INNER JOIN roles
            ON roles.role_id=users.user_role;"
        );

        mysqli_close($conection);

        $userArray = [];
        while ($responseArray = mysqli_fetch_assoc($userResult)) {
            $user = new UserModel(
                (string)    $responseArray["user_name"],
                (string)    $responseArray["user_password"],
                (string)    $responseArray["role_name"],
                (int)       $responseArray["user_dni"],
                (string)    $responseArray["user_email"],
                (string)    $responseArray["user_birthday"],
                (int)       $responseArray["user_id"]
            );

            array_push($userArray, $user);
        }

        return $userArray;
    }

    public static function getRoles()
    {
        $conection = DBConection::getDBConnection();
        $roleResult = mysqli_query(
            $conection,
            "SELECT * FROM roles;"
        );

        mysqli_close($conection);

        $roleArray = [];
        while ($responseArray = mysqli_fetch_assoc($roleResult)) {
            $user = new UserRole(
                (string)     $responseArray["role_name"],
                (int)   $responseArray["role_id"]
            );

            array_push($roleArray, $user);
        }

        return $roleArray;
    }

    public static function getUserByEmail(String $email)
    {
        if (!UserDAO::existsEmail($email))
            return false;

        $conection = DBConection::getDBConnection();
        $result = mysqli_query(
            $conection,
            "SELECT user_password,user_name,user_id,user_dni,user_email,user_birthday,role_name
                FROM users 
                INNER JOIN roles
                ON roles.role_id=users.user_role
                WHERE user_email = '" . $email . "'"
        );
        mysqli_close($conection);

        $responseArray = mysqli_fetch_assoc($result);
        $validatedUser = new UserModel(
            (string)    $responseArray["user_name"],
            (string)    $responseArray["user_password"],
            (string)    $responseArray["role_name"],
            (int)       $responseArray["user_dni"],
            (string)    $responseArray["user_email"],
            (string)    $responseArray["user_birthday"],
            (int)       $responseArray["user_id"]
        );

        return $validatedUser;
    }

    public static function getUserById(int $id)
    {
        $conection = DBConection::getDBConnection();
        $result = mysqli_query(
            $conection,
            "SELECT user_password,user_name,user_id,user_dni,user_email,user_birthday,role_name
                FROM users 
                INNER JOIN roles
                ON roles.role_id=users.user_role
                WHERE user_id = '" . $id . "'"
        );
        mysqli_close($conection);

        $responseArray = mysqli_fetch_assoc($result);
        $validatedUser = new UserModel(
            (string)    $responseArray["user_name"],
            (string)    $responseArray["user_password"],
            (string)    $responseArray["role_name"],
            (int)       $responseArray["user_dni"],
            (string)    $responseArray["user_email"],
            (string)    $responseArray["user_birthday"],
            (int)       $responseArray["user_id"]
        );

        return $validatedUser;
    }

    public static function deleteUser(int $id)
    {
        $conection = DBConection::getDBConnection();
        mysqli_query(
            $conection,
            "DELETE FROM users WHERE user_id = '" . $id . "'"
        );
        mysqli_close($conection);
    }

    public static function isThisDateValid(String $date)
    {
        $datArr = explode('-', $date);

        if (!checkdate($datArr[1], $datArr[2], $datArr[0]))
            return false;

        return true;
    }

    public static function isThisUserDataValid(UserModel $user)
    {
        if (!UserDAO::isThisPasswordValid($user->getPassword()))
            return 'bad password';

        if (!UserDAO::isThisUsernameValid($user->getName()))
            return 'bad user name';

        if (!UserDAO::isThisDateValid($user->getBirthday()))
            return 'bad date';

        return false;
    }

    public static function addUser(UserModel $user)
    {
        if (UserDAO::isThisUserDataValid($user))
            return UserDAO::isThisUserDataValid($user);

        else if (UserDAO::existsEmail($user->getEmail()))
            return 'the email is already registered';

        else if (UserDAO::existsDni($user->getDni()))
            return 'the dni is already registered';

        else if (UserDAO::existsUsername($user->getName()))
            return 'the user name is already registered';

        else {
            $conection = DBConection::getDBConnection();
            $result = mysqli_query($conection, "SELECT role_id FROM roles WHERE role_name = '" . $user->getRole() . "'");
            $response = mysqli_query(
                $conection,
                "INSERT INTO users(user_name, user_password, user_role, user_dni, user_email, user_birthday)
            VALUES ('" .
                    $user->getName() . "', '" .
                    password_hash($user->getPassword(), PASSWORD_DEFAULT) . "', " .
                    (int) mysqli_fetch_assoc($result)["role_id"] . ", " .
                    (int) $user->getDni() . ", '" .
                    $user->getEmail() . "', '" .
                    $user->getBirthday() . "');"
            );

            mysqli_close($conection);

            return $user;
        }
    }

    public static function updateUser(UserModel $userData)
    {
        $conection = DBConection::getDBConnection();
        $result = mysqli_query($conection, "SELECT role_id FROM roles WHERE role_name = '" . $userData->getRole() . "'");

        if ($result) {
            mysqli_query(
                $conection,
                "UPDATE users 
                SET     
                    user_name='" . $userData->getName() . "',
                    user_password='" . password_hash($userData->getPassword(), PASSWORD_DEFAULT) . "', 
                    user_role='" .  mysqli_fetch_assoc($result)["role_id"] . "', 
                    user_dni='" . $userData->getDni() . "', 
                    user_email='" . $userData->getEmail() . "', 
                    user_birthday='" . $userData->getBirthday() . "'
                    
                WHERE user_id = '" . $userData->getId() . "'"
            );

            mysqli_close($conection);
        }
    }
}
