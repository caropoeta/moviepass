<?php

namespace DAO;

use Exception;
use Models\UserRole as UserRole;
use PDO;
use PDOException;

class RolesDAO
{
    public static function getRoles()
    {
        try {
            $conection = Connection::GetInstance();
            $query = "
            select * from roles;";
            $response = $conection->Execute($query);
        } catch (PDOException $ex) {
            throw $ex;
        }

        $roleArray = array_map(function (array $obj) {
            return UserRole::fromArray($obj);
        }, $response);

        return $roleArray;
    }

    public static function getRoleById(int $id)
    {
        $conection = Connection::GetInstance();
        $query = "
        select * from roles where role_id = :id;";
        $response = $conection->Execute($query, array('id' => $id));

        $roleArray = array_map(function (array $obj) {
            return UserRole::fromArray($obj);
        }, $response);

        return ((isset($roleArray[0])) ? $roleArray[0] : null);
    }

    public static function getRoleByName(String $name)
    {
        $conection = Connection::GetInstance();
        $query = "
        select * from roles where role_name = :name;";
        $response = $conection->Execute($query, array('name' => $name));

        $roleArray = array_map(function (array $obj) {
            return UserRole::fromArray($obj);
        }, $response);

        return ((isset($roleArray[0])) ? $roleArray[0] : null);
    }
}
