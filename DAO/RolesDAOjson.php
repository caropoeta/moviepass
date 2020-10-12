<?php

namespace DAO;

use Models\UserRole as UserRole;

class RolesDAOjson
{
    private static function getFilename()
    {
        return ROOT . DATA_PATH . "Roles.json";
    }

    private static function Save(array $objs)
    {
        $toEncode = [];
        foreach ($objs as $obj) {
            if ($obj instanceof UserRole) {
                $val = [];
                $val['name'] = $obj->getName();
                $val['id'] = $obj->getId();
                array_push($toEncode, $val);
            }
        }

        $encoded = json_encode($toEncode, JSON_PRETTY_PRINT);
        file_put_contents(RolesDAOjson::getFilename(), $encoded);
    }

    private static function Load()
    {
        $toReturn = [];

        if (file_exists(RolesDAOjson::getFilename())) {
            $toDecode = file_get_contents(RolesDAOjson::getFilename());
            $decoded = ($toDecode) ? json_decode($toDecode, true) : [];

            foreach ($decoded as $value) {
                array_push($toReturn, new UserRole($value['name'], $value['id']));
            }
        }

        return $toReturn;
    }

    public static function getRoles()
    {
        return RolesDAOjson::Load();
    }

    public static function getRoleById(int $id)
    {
        $result = RolesDAOjson::Load();
        foreach ($result as $value) {
            if ($value instanceof UserRole) {
                if ($value->getId() == $id) {
                    return $value;
                }
            }
        }

        return false;
    }

    public static function getRoleByName(String $name)
    {
        $result = RolesDAOjson::Load();
        foreach ($result as $value) {
            if ($value instanceof UserRole) {
                if ($value->getName() == $name) {
                    return $value;
                }
            }
        }

        return false;
    }

    public static function delete(int $id)
    {
        $result = RolesDAOjson::Load();
        for ($i = 0; $i < count($result); $i++) {
            $value = $result[$i];

            if ($value instanceof UserRole) {
                if ($value->getId() == $id) {
                    unset($result[$i]);
                    array_values($result);
                }
            }
        }

        RolesDAOjson::Save($result);

        return;
    }

    public static function add(UserRole $role)
    {
        $result = RolesDAOjson::Load();
        array_push($result, $role);
        RolesDAOjson::Save($result);

        return $role;
    }
}
