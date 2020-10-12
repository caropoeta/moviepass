<?php

namespace DAO;

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
        if (!UserDAOjson::isThisUsernameValid($username) || !UserDAOjson::isThisPasswordValid($password))
            return false;

        $result = UserDAOjson::Load();
        foreach ($result as $value) {
            if ($value instanceof UserModel) {
                if ($value->getName() == $username) {
                    if (password_verify($password, $value->getPassword())) {
                        return $value;
                    }
                }
            }
        }

        return false;
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
        if (!UserDAOjson::isThisPasswordValid($user->getPassword()))
            return 'bad password';

        if (!UserDAOjson::isThisUsernameValid($user->getName()))
            return 'bad user name';

        if (!UserDAOjson::isThisDateValid($user->getBirthday()))
            return 'bad date';

        return false;
    }

    public static function addUser(UserModel $user)
    {
        if (UserDAOjson::isThisUserDataValid($user))
            return UserDAOjson::isThisUserDataValid($user);

        else if (UserDAOjson::existsEmail($user->getEmail()))
            return 'the email is already registered';

        else if (UserDAOjson::existsDni($user->getDni()))
            return 'the dni is already registered';

        else if (UserDAOjson::existsUsername($user->getName()))
            return 'the user name is already registered';

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
        $conection = DBConection::getDBConnection();
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
