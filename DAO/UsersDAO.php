<?php

namespace DAO;

use Models\Exceptions\AddUserException;
use Models\Exceptions\UpdateUserException;
use Models\Exceptions\ValidateUserCredentialsException;
use Models\UserModel as UserModel;

class UsersDAO
{
    private static function isThisStringValid(String $string)
    {
        return (trim($string)) ? true : false;
    }

    public static function isThisPasswordValid(String $password)
    {
        return UsersDAO::isThisStringValid($password);
    }

    public static function isThisUsernameValid(String $password)
    {
        return UsersDAO::isThisStringValid($password);
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
        if (!UsersDAO::isThisPasswordValid($user->getPassword()))
            return 'bad password';

        if (!UsersDAO::isThisUsernameValid($user->getName()))
            return 'bad user name';

        if (!UsersDAO::isThisDateValid($user->getBirthday()))
            return 'bad date';

        return false;
    }

    public static function existsEmail(String $obj)
    {
        $conection = Connection::GetInstance();
        $query = "select true from users where user_email = :email;";
        $response = $conection->Execute($query, array('email' => $obj));

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }

    public static function existsUsername(String $username)
    {
        if (!UsersDAO::isThisUsernameValid($username))
            return false;

        $conection = Connection::GetInstance();
        $query = "select true from users where user_name = :username;";
        $response = $conection->Execute($query, array('username' => $username));

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }

    public static function existsDni(int $obj)
    {
        $conection = Connection::GetInstance();
        $query = "select true from users where user_dni = :dni;";
        $response = $conection->Execute($query, array('dni' => $obj));

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }


    public static function getUsers(String $name = "", String $email = "", String $dni = "", String $role = "")

    {
        $conection = Connection::GetInstance();
        $query = "
        SELECT * 
        FROM users
        INNER JOIN roles
        ON roles.role_id=users.user_role

        WHERE user_name like :name
        AND user_email like :email
        AND CAST(user_dni as varchar(50)) like :dni
        AND CAST(user_role as varchar(50)) like :role
        ;";

        $params = [];
        if ($name == "")
            $params['name']     = '%';
        else
            $params['name']     = '%' . $name . '%';

        if ($email == "")
            $params['email']    = '%';
        else
            $params['email']    = '%' . $email . '%';

        if ($role == "")
            $params['role']     = '%';
        else
            $params['role']     = '%' . $role . '%';

        if ($dni == "")
            $params['dni']      = '%';
        else
            $params['dni']      = '%' . $dni . '%';

        $response = $conection->Execute($query, $params);


        $userArray = array_map(function (array $obj) {
            return UserModel::fromArray($obj);
        }, $response);

        return $userArray;
    }

    public static function getUserByEmail(String $email)
    {
        if (!UsersDAO::existsEmail($email))
            return false;

        $conection = Connection::GetInstance();
        $query = "
            SELECT user_password,user_name,user_id,user_dni,user_email,user_birthday,role_name
            FROM users 
            INNER JOIN roles
            ON roles.role_id = users.user_role
            WHERE user_email = :email";
        $response = $conection->Execute($query, array('email' => $email));

        $userArray = array_map(function (array $obj) {
            return UserModel::fromArray($obj);
        }, $response);

        return ((isset($userArray[0])) ? $userArray[0] : null);
    }

    public static function getUserById(int $id)
    {
        $conection = Connection::GetInstance();
        $query = "
            SELECT user_password,user_name,user_id,user_dni,user_email,user_birthday,role_name
            FROM users 
            INNER JOIN roles
            ON roles.role_id = users.user_role
            WHERE user_id = :id";
        $response = $conection->Execute($query, array('id' => $id));

        $userArray = array_map(function (array $obj) {
            return UserModel::fromArray($obj);
        }, $response);

        return ((isset($userArray[0])) ? $userArray[0] : null);
    }

    public static function validateUserCredentials(String $username, String $password)
    {
        $exceptionArray = [];

        if (!UsersDAO::isThisUsernameValid($username))
            array_push($exceptionArray, 'This user name is wrong');

        if (!UsersDAO::isThisPasswordValid($password))
            array_push($exceptionArray, 'This password is wrong');

        if (!empty($exceptionArray))
            throw new ValidateUserCredentialsException("Error Processing Request", $exceptionArray, 1);

        if (!UsersDAO::existsUsername($username)) {
            array_push($exceptionArray, 'This user name does not exist');
            throw new ValidateUserCredentialsException("Error Processing Request", $exceptionArray, 1);
        }

        $conection = Connection::GetInstance();
        $query = "
            SELECT * FROM users 
            INNER JOIN roles
            ON roles.role_id=users.user_role
            WHERE user_name = :username";

        $response = $conection->Execute(
            $query,
            array('username' => $username)
        );

        if ($response != null && (sizeof($response) > 0)) {
            $userArray = array_map(function (array $obj) {
                return UserModel::fromArray($obj);
            }, $response);

            if (isset($userArray[0])) {
                if ($userArray[0] instanceof UserModel)
                    if (password_verify($password, $userArray[0]->getPassword())) {
                        return $userArray[0];
                    }
            }
        }

        array_push($exceptionArray, 'The password was incorrect');
        throw new ValidateUserCredentialsException("Error Processing Request", $exceptionArray, 1);
    }

    public static function deleteUser(int $id)
    {
        $conection = Connection::GetInstance();
        $query = "DELETE FROM users WHERE user_id = :id";

        $response = $conection->ExecuteNonQuery(
            $query,
            array('id' => $id)
        );
    }

    public static function addUser(UserModel $user)
    {
        $exceptionArray = [];

        $isThisUserDataValid = UsersDAO::isThisUserDataValid($user);
        if (!empty($isThisUserDataValid))
            array_merge($exceptionArray, $isThisUserDataValid);

        if (UsersDAO::existsEmail($user->getEmail()))
            array_push($exceptionArray, 'This email is already registered');

        if (UsersDAO::existsDni($user->getDni()))
            array_push($exceptionArray, 'This dni is already registered');

        if (UsersDAO::existsUsername($user->getName()))
            array_push($exceptionArray, 'This user name is already registered');

        if (!empty($exceptionArray))
            throw new AddUserException("Error Processing Request", $exceptionArray, 1);

        else {
            $conection = Connection::GetInstance();
            $query = "
            INSERT INTO users(user_name, user_password, user_role, user_dni, user_email, user_birthday)
            VALUES (:name,:password,:role,:dni,:email,:birthday);";

            $params = [];
            $params['name']         = $user->getName();
            $params['password']     = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $params['role']         = RolesDAO::getRoleByName($user->getRole())->getId();
            $params['dni']          = $user->getDni();
            $params['email']        = $user->getEmail();
            $params['birthday']     = $user->getBirthday();

            $conection->ExecuteNonQuery(
                $query,
                $params
            );

            return UsersDAO::getUserByEmail($user->getEmail());
        }
    }

    public static function updateUser(UserModel $userData)
    {
        $currUser = UsersDAO::getUserById($userData->getId());

        $exceptionArray = [];

        $isThisUserDataValid = UsersDAO::isThisUserDataValid($userData);
        if ($isThisUserDataValid)
            array_merge($exceptionArray, $isThisUserDataValid);

        if ($currUser->getEmail() != $userData->getEmail())
            if (UsersDAO::existsEmail($userData->getEmail()))
                array_push($exceptionArray, 'This email is already registered');

        if ($currUser->getDni() != $userData->getDni())
            if (UsersDAO::existsDni($userData->getDni()))
                array_push($exceptionArray, 'This dni is already registered');

        if ($currUser->getName() != $userData->getName())
            if (UsersDAO::existsUsername($userData->getName()))
                array_push($exceptionArray, 'This user name is already registered');

        if (!empty($exceptionArray))
            throw new UpdateUserException("Error Processing Request", $exceptionArray, 1);

        else {
            $conection = Connection::GetInstance();
            $query = "
                UPDATE users 
                SET     
                    user_name = :name,
                    user_password = :password, 
                    user_role = :role, 
                    user_dni = :dni, 
                    user_email = :email, 
                    user_birthday = :birthday
                WHERE user_id = :id";

            $params = [];
            $params['id']           = $userData->getId();
            $params['name']         = $userData->getName();
            $params['dni']          = $userData->getDni();
            $params['email']        = $userData->getEmail();
            $params['birthday']     = $userData->getBirthday();
            $params['role']         = RolesDAO::getRoleByName($userData->getRole())->getId();
            $params['password']     =
                ($userData->getPassword() == $currUser->getPassword())
                ? $currUser->getPassword()
                : password_hash($userData->getPassword(), PASSWORD_DEFAULT);

            $conection->ExecuteNonQuery(
                $query,
                $params
            );

            return UsersDAO::getUserById($userData->getId());
        }
    }
}
