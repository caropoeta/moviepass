<?php

namespace DAO;

use Exception;
use Models\Genre;
use PDOException;

class GenreDAO
{
    public static function getGenres()
    {
        try {
            $conection = Connection::GetInstance();
            $query = "
            select * from genres";

            $response = $conection->Execute($query);
        } catch (PDOException $th) {
            throw $th;
        }

        $roleArray = array_map(function (array $obj) {
            return Genre::fromArray($obj);
        }, $response);

        return $roleArray;
    }

    public static function getGenreById(int $id)
    {
        try {
            $conection = Connection::GetInstance();
            $query = "
            select * from genres where id = :id;";

            $response = $conection->Execute($query, array('id' => $id));
        } catch (PDOException $th) {
            throw $th;
        }

        $roleArray = array_map(function (array $obj) {
            return Genre::fromArray($obj);
        }, $response);

        return ((isset($roleArray[0])) ? $roleArray[0] : null);
    }

    public static function getGenreByName(int $name)
    {
        try {
            $conection = Connection::GetInstance();
            $query = "
            select * from genres where name = :name;";
            $response = $conection->Execute($query, array('name' => $name));
        } catch (PDOException $th) {
            throw $th;
        }

        $roleArray = array_map(function (array $obj) {
            return Genre::fromArray($obj);
        }, $response);

        return ((isset($roleArray[0])) ? $roleArray[0] : null);
    }

    public static function addGenre(Genre $genre)
    {
        if (!GenreDAO::checkGenreById($genre->getId())) {
            try {
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
            } catch (PDOException $th) {
                throw $th;
            }
        }
    }

    public static function checkGenreById(int $id)
    {
        try {
            $conection = Connection::GetInstance();
            $query = "select true from genres where id = :id;";
            $response = $conection->Execute($query, array('id' => $id));
        } catch (PDOException $th) {
            throw $th;
        }

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }
}
