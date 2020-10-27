<?php

namespace DAO;

use DateTime;
use Models\Functions;
use Models\Movie;

class FunctionsDAO
{
    public static function delete(int $id)
    {
        $query = "update functions set deleted = 0 where id = :id";
        $param = [];
        $param['id'] = $id;

        $conection = Connection::GetInstance();
        $response = $conection->ExecuteNonQuerry($query, $param);
    }

    public static function getAllFromRoom(int $id)
    {
        $query = "select * from functions where deleted = 0 and idRoom = :room";
        $param = [];
        $param['room'] = $id;

        $conection = Connection::GetInstance();
        $response = $conection->Execute($query, $param);

        $roleArray = array_map(function (array $obj) {
            $funToReturn = new Functions();
            $funToReturn->setidFunction($obj['id']);
            $funToReturn->setTime((String) date('h:i:s', strtotime($obj['time'])));
            $funToReturn->setfinishTime((String) date('h:i:s', strtotime($obj['finishTime'])));
            $funToReturn->setMovie(MovieDAO::getMovieById($obj['idMovie']));
            $funToReturn->setidRoom($obj['idRoom']);
            $funToReturn->setDeleteFunction($obj['deleted']);

            return $funToReturn;
        }, $response);

        return $roleArray;
    }
}
