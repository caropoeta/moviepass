<?php

namespace DAO;

use Models\UserRole as UserRole;

class RolesDAO
{
    public static function getRoles()
    {
        $conection = Connection::GetInstance();
        $query = "
        select * from roles;";
        $response = $conection->Execute($query);

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
