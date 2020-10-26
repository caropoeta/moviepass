<?php

namespace DAO;

use DateTime;
use Models\Functions;
use Models\Movie;

class FunctionsDAO
{
    public static function add(Functions $obj)
    {
        # code...
    }

    public static function delete(int $id)
    {
        $query = "update functions set deleted = 0 where id = :id";
        $param = [];
        $param['id'] = $id;

        $conection = Connection::GetInstance();
        $response = $conection->ExecuteNonQuerry($query, $param);
    }

    public static function update(Functions $obj)
    {
    }

    public static function getAllFromRoom(int $id)
    {
        $query = "select * from functions where deleted = 0";
        $param = [];

        $conection = Connection::GetInstance();
        $response = $conection->Execute($query, $param);

        $roleArray = array_map(function (array $obj) {
            $funToReturn = new Functions();
            $funToReturn->setidFunction($obj['id']);
            $funToReturn->setTime((String) $obj['time']);
            $funToReturn->setMovie(MovieDAO::getMovieById($obj['idMovie']));
            $funToReturn->setidRoom($obj['idRoom']);
            $funToReturn->setDeleteFunction($obj['deleted']);

            $funToReturn->setfinishTime(
                (String) date(
                    'h:i:s',strtotime(
                        "+" . $funToReturn->getMovie()->getRuntime(), 
                        strtotime($obj['time'])
                    )
                )
            );

            return $funToReturn;
        }, $response);

        return $roleArray;
    }
}
