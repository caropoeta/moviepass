<?php

namespace DAO;

use Models\Genre;

class GenreDAO
{
    public static function getGenreById(int $id)
    {
        $conection = Connection::GetInstance();
        $query = "
        select * from genres where id = :id;";
        $response = $conection->Execute($query, array('id' => $id));

        $roleArray = array_map(function (array $obj) {
            return Genre::fromArray($obj);
        }, $response);

        return ((isset($roleArray[0])) ? $roleArray[0] : null);
    }

    public static function getGenreByName(int $name)
    {
        $conection = Connection::GetInstance();
        $query = "
        select * from genres where name = :name;";
        $response = $conection->Execute($query, array('name' => $name));

        $roleArray = array_map(function (array $obj) {
            return Genre::fromArray($obj);
        }, $response);

        return ((isset($roleArray[0])) ? $roleArray[0] : null);
    }

    public static function addGenre(Genre $genre)
    {
        if (!GenreDAO::checkGenreById($genre->getId())) {
            $conection = Connection::GetInstance();
            $query = "
            INSERT INTO `genres`(`id`, `name`) 
            VALUES (:id, :name)";

            $params = [];
            $params['id']   = $genre->getId();
            $params['name'] = $genre->getDescription();

            $conection->ExecuteNonQuery(
                $query,
                $params
            );
        }
    }

    public static function checkGenreById(int $id)
    {
        $conection = Connection::GetInstance();
        $query = "select true from genres where id = :id;";
        $response = $conection->Execute($query, array('id' => $id));

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }

    public static function searchInGeneres(int $id, array $wG)
    {
        foreach ($wG as $value) {
            if ($value == $id)
                return true;
        }

        return false;
    }
}
