<?php

namespace DAO;

use Models\Exceptions\AddUserException;
use Models\Exceptions\ValidateUserCredentialsException;
use Models\UserModel as UserModel;
use Models\UserRole as UserRole;

class UserDAOjson
{
    private static function getFilename()
    {
        return ROOT . DATA_PATH . "Users.json";
    }

    private static function Save(array $objs)
    {
        $toEncode = [];
        foreach ($objs as $obj) {
            if ($obj instanceof UserModel) {
                $val = [];
                $val['username'] = $obj->getName();
                $val['id'] = $obj->getId();
                $val['password'] = $obj->getPassword();
                $val['birthday'] = $obj->getBirthday();
                $val['email'] = $obj->getEmail();
                $val['dni'] = $obj->getDni();
                $val['role'] = $obj->getRole();

                array_push($toEncode, $val);
            }
        }

        $encoded = json_encode($toEncode, JSON_PRETTY_PRINT);
        file_put_contents(UserDAOjson::getFilename(), $encoded);
    }

    private static function Load()
    {
        $toReturn = [];

        if (file_exists(UserDAOjson::getFilename())) {
            $toDecode = file_get_contents(UserDAOjson::getFilename());
            $decoded = ($toDecode) ? json_decode($toDecode, true) : [];

            foreach ($decoded as $value) {
                array_push($toReturn, new UserModel(
                    $value['username'],
                    $value['password'],
                    $value['role'],
                    $value['dni'],
                    $value['email'],
                    $value['birthday'],
                    $value['id']
                ));
            }
        }

        return $toReturn;
    }

    private static function getLastId()
    {
        $lastId = 0;
        $result = UserDAOjson::Load();
        foreach ($result as $value) {
            if ($value instanceof UserModel) {
                if ($value->getId() > $lastId) {
                    $lastId = $value->getId();
                }
            }
        }

        return $lastId;
    }

    private static function isThisStringValid(String $string)
    {
        return (trim($string)) ? true : false;
    }

    public static function existsUsername(String $username)
    {
        if (!UserDAOjson::isThisUsernameValid($username))
            return false;

        $result = UserDAOjson::Load();
        foreach ($result as $value) {
            if ($value instanceof UserModel) {
                if ($value->getName() == $username) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function existsEmail(String $obj)
    {
        $result = UserDAOjson::Load();
        foreach ($result as $value) {
            if ($value instanceof UserModel) {
                if ($value->getEmail() == $obj) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function existsDni(int $obj)
    {
        $result = UserDAOjson::Load();
        foreach ($result as $value) {
            if ($value instanceof UserModel) {
                if ($value->getDni() == $obj) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function isThisPasswordValid(String $password)
    {
        return UserDAOjson::isThisStringValid($password);
    }

    public static function isThisUsernameValid(String $password)
    {
        return UserDAOjson::isThisStringValid($password);
    }

    public static function validateUserCredentials(String $username, String $password)
    {
        $exceptionArray = [];

        if (!UserDAOjson::isThisUsernameValid($username))
            array_push($exceptionArray, 'This user name is wrong');

        if (!UserDAOjson::isThisPasswordValid($password))
            array_push($exceptionArray, 'This password is wrong');

        if (!empty($exceptionArray))
            throw new ValidateUserCredentialsException("Error Processing Request", $exceptionArray, 1);

        if (!UserDaoJson::existsUsername($username)) {
            array_push($exceptionArray, 'This user name does not exist');
            throw new ValidateUserCredentialsException("Error Processing Request", $exceptionArray, 1);
        }

        $result = UserDAOjson::Load();
        foreach ($result as $value) {
            if ($value instanceof UserModel) {
                if ($value->getName() == $username) {
                    if ($password == $value->getPassword()) {
                        return $value;
                    }
                }
            }
        }

        array_push($exceptionArray, 'The password was incorrect');
        throw new ValidateUserCredentialsException("Error Processing Request", $exceptionArray, 1);
    }

    public static function getUsers()
    {
        return UserDAOjson::Load();
    }

    public static function getRoles()
    {
        return RolesDAOjson::getRoles();
    }

    public static function getUserByEmail(String $email)
    {
        if (!UserDAOjson::existsEmail($email))
            return false;

        $result = UserDAOjson::Load();
        foreach ($result as $value) {
            if ($value instanceof UserModel) {
                if ($value->getEmail() == $email) {
                    return $value;
                }
            }
        }

        return false;
    }

    public static function getUserById(int $id)
    {
        $result = UserDAOjson::Load();
        foreach ($result as $value) {
            if ($value instanceof UserModel) {
                if ($value->getId() == $id) {
                    return $value;
                }
            }
        }

        return false;
    }

    public static function deleteUser(int $id)
    {
        $result = UserDAOjson::Load();
        for ($i = 0; $i < count($result); $i++) {
            $value = $result[$i];

            if ($value instanceof UserModel) {
                if ($value->getId() == $id) {
                    unset($result[$i]);
                    array_values($result);
                }
            }
        }

        UserDAOjson::Save($result);

        return;
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
        $array = [];
        if (!UserDAOjson::isThisPasswordValid($user->getPassword()))
            array_push($array, 'Wrong password');

        if (!UserDAOjson::isThisUsernameValid($user->getName()))
            array_push($array, 'Wrong user name');

        if (!UserDAOjson::isThisDateValid($user->getBirthday()))
            array_push($array, 'Wrong date');

        return !empty($array) ? $array : false;
    }

    public static function addUser(UserModel $user)
    {
        $exceptionArray = [];

        $isThisUserDataValid = UserDAOjson::isThisUserDataValid($user);
        if ($isThisUserDataValid)
            array_merge($exceptionArray, $isThisUserDataValid);

        if (UserDAOjson::existsEmail($user->getEmail()))
            array_push($exceptionArray, 'This email is already registered');

        if (UserDAOjson::existsDni($user->getDni()))
            array_push($exceptionArray, 'This dni is already registered');

        if (UserDAOjson::existsUsername($user->getName()))
            array_push($exceptionArray, 'This user name is already registered');

        if (!empty($exceptionArray))
            throw new AddUserException("Error Processing Request", $exceptionArray, 1);

        else {
            $result = UserDAOjson::Load();
            $user->setId(UserDAOjson::getLastId() + 1);
            array_push($result, $user);
            UserDAOjson::Save($result);

            return $user;
        }
    }

    public static function updateUser(UserModel $userData)
    {
        $currUser = UserDAOjson::getUserById($userData->getId());

        $exceptionArray = [];

        $isThisUserDataValid = UserDAOjson::isThisUserDataValid($userData);
        if ($isThisUserDataValid)
            array_merge($exceptionArray, $isThisUserDataValid);

        if ($currUser->getEmail() != $userData->getEmail())
            if (UserDAOjson::existsEmail($userData->getEmail()))
                array_push($exceptionArray, 'This email is already registered');

        if ($currUser->getEmail() != $userData->getDni())
            if (UserDAOjson::existsDni($userData->getDni()))
                array_push($exceptionArray, 'This dni is already registered');

        if ($currUser->getEmail() != $userData->getName())
            if (UserDAOjson::existsUsername($userData->getName()))
                array_push($exceptionArray, 'This user name is already registered');

        if (!empty($exceptionArray))
            throw new AddUserException("Error Processing Request", $exceptionArray, 1);

        $result = UserDAOjson::Load();
        for ($i = 0; $i < count($result); $i++) {
            $value = $result[$i];

            if ($value instanceof UserModel) {
                if ($value->getId() == $userData->getId()) {
                    $result[$i] = $userData;
                }
            }
        }

        UserDAOjson::Save($result);

        return;
    }
}
