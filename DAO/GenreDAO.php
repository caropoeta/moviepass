<?php

namespace DAO;

use Models\Genre;

class GenreDAO
{
    public static function getGenres()
    {
        $conection = Connection::GetInstance();
        $query = "
        select * from genres";
        $response = $conection->Execute($query);

        $roleArray = array_map(function (array $obj) {
            return Genre::fromArray($obj);
        }, $response);

        return $roleArray;
    }

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
}
