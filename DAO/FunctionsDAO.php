<?php

namespace DAO;

use DateTime;
use Exception;
use Models\Exceptions\ArrayException;
use Models\Functions;
use Models\Movie;
use PDO;
use PDOException;

class FunctionsDAO
{
    public static function checkIfMovieIsInDayInCinema(int $idMov, String $day, $functionId = NULL)
    {
        $conection = Connection::GetInstance();
        $query = "
        select cinemas.idCinema, functions.idMovie, functions.day, functions.deleted
        from functions
        inner join rooms
        on functions.idRoom = rooms.idRoom
        inner join cinemas
        on cinemas.idCinema = rooms.idCinema 
        
        where functions.day = :day
        and functions.idMovie = :idMovie
        and functions.deleted = 0
        ";

        $param = array('idMovie' => $idMov, 'day' => $day);

        if ($functionId != NULL) {
            $query = $query . 'and functions.id != :funid';
            $param['funid'] = $functionId;
        }

        $response = $conection->Execute($query, $param);

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }

    public static function checkIfEndCollideWithFunctionInRoom(String $start, String $end, int $idRoom, String $date, $functionId = NULL)
    {
        $conection = Connection::GetInstance();
        $query = "
        select functions.time, functions.finishTime, functions.idRoom
        from functions
        inner join rooms
        on functions.idRoom = rooms.idRoom
        inner join cinemas
        on cinemas.idCinema = rooms.idCinema 
        
        where functions.idRoom = :idRoom
        and functions.finishTime between :start and :end
        and functions.deleted = 0
        and functions.day = :day
        ";

        $param = array('start' => $start, 'end' => $end, 'idRoom' => $idRoom, 'day' => $date);

        if ($functionId != NULL) {
            $query = $query . 'and functions.id != :funid';
            $param['funid'] = $functionId;
        }

        $response = $conection->Execute(
            $query,
            $param
        );

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }

    public static function checkIfStartCollideWithFunctionInRoom(String $start, String $end, int $idRoom, String $date, $functionId = null)
    {
        $conection = Connection::GetInstance();
        $query = "
        select functions.time, functions.finishTime, functions.idRoom
        from functions
        inner join rooms
        on functions.idRoom = rooms.idRoom
        inner join cinemas
        on cinemas.idCinema = rooms.idCinema 
        
        where functions.idRoom = :idRoom
        and functions.time between :start and :end
        and functions.deleted = 0
        and functions.day = :day
        ";

        $param = array('start' => $start, 'end' => $end, 'idRoom' => $idRoom, 'day' => $date);

        if ($functionId != NULL) {
            $query = $query . 'and functions.id != :funid';
            $param['funid'] = $functionId;
        }

        $response = $conection->Execute(
            $query,
            $param
        );

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }

    public static function add(String $time, String $date, int $roomId, int $movieId)
    {
        $date = (string) date('Y-m-d', strtotime($date));

        $exceptionArray = [];

        /*problemas con el dia de funcion*/
        if (FunctionsDAO::checkIfMovieIsInDayInCinema($movieId, $date))
            array_push($exceptionArray, "The Movie is already ocupied for that day");
        /*problemas con el dia de funcion*/

        /*problemas con los tiempos de funcion*/
        $startimtime = (string) date('H:i:s', strtotime($time));

        $movieTiTime = (string) date('h:i:s', strtotime(MovieDAO::getMovieById($movieId)->getRuntime()));

        $finnishtime = (string) date('H:i:s', strtotime($time));

        $finnishtime = date('H:i:s', strtotime('+' . (string) date('h', strtotime($movieTiTime)) . ' hour',     strtotime($finnishtime)));
        $finnishtime = date('H:i:s', strtotime('+' . (string) date('i', strtotime($movieTiTime)) . ' minute',   strtotime($finnishtime)));
        $finnishtime = date('H:i:s', strtotime('+' . (string) date('s', strtotime($movieTiTime)) . ' second',   strtotime($finnishtime)));

        $cin = RoomDBDAO::getCinemaByRoomId($roomId);
        $startimtime_15minOffset = date('H:i:s', strtotime('-15 minute',  strtotime($startimtime)));
        $finnishtime_15minOffset = date('H:i:s', strtotime('+15 minute',  strtotime($finnishtime)));

        /*buscar si chocan con los tiempos de cine*/
        if (strtotime($cin->getopeningTime()) >= strtotime($startimtime_15minOffset))
            array_push($exceptionArray, "The start of the function conflicts with the opening time");

        if (
            strtotime($cin->getclosingTime()) <= strtotime($finnishtime_15minOffset) ||
            strtotime($finnishtime) <= strtotime($startimtime)
        )
            array_push($exceptionArray, "The end of the function conflicts with the closing time");

        /*buscar si chocan con los tiempos de funciones*/
        if (FunctionsDAO::checkIfStartCollideWithFunctionInRoom($startimtime_15minOffset, $finnishtime_15minOffset, $roomId, $date))
            array_push($exceptionArray, "This function collides with another function's start");

        if (FunctionsDAO::checkIfEndCollideWithFunctionInRoom($startimtime_15minOffset, $finnishtime_15minOffset, $roomId, $date))
            array_push($exceptionArray, "This function collides with another function's end");
        /*problemas con los tiempos de funcion*/

        if (!empty($exceptionArray))
            throw new ArrayException("Error Processing Request", $exceptionArray, 1);

        else {
            $query = "insert into functions(time, idMovie, idRoom, deleted, finishTime, day) 
            values (:time, :idMovie, :idRoom, :deleted, :finishTime, :day)";
            $param = [];
            $param['time'] = $startimtime;
            $param['idMovie'] = $movieId;
            $param['idRoom'] = $roomId;
            $param['deleted'] = 0;
            $param['finishTime'] = $finnishtime;
            $param['day'] = $date;

            try {
                $conection = Connection::GetInstance();
                $response = $conection->ExecuteNonQuery($query, $param);
            } catch (PDOException $th) {
                throw $th;
            }
        }
    }

    public static function update(String $time, String $date, int $roomId, int $functionId, int $movieId)
    {
        $date = (string) date('Y-m-d', strtotime($date));

        $exceptionArray = [];

        /*problemas con el dia de funcion*/
        if (FunctionsDAO::checkIfMovieIsInDayInCinema($movieId, $date, $functionId))
            array_push($exceptionArray, "The Movie is already ocupied for that day");
        /*problemas con el dia de funcion*/

        /*problemas con los tiempos de funcion*/
        $startimtime = (string) date('H:i:s', strtotime($time));

        $movieTiTime = (string) date('h:i:s', strtotime(MovieDAO::getMovieById($movieId)->getRuntime()));

        $finnishtime = (string) date('H:i:s', strtotime($time));

        $finnishtime = date('H:i:s', strtotime('+' . (string) date('h', strtotime($movieTiTime)) . ' hour',     strtotime($finnishtime)));
        $finnishtime = date('H:i:s', strtotime('+' . (string) date('i', strtotime($movieTiTime)) . ' minute',   strtotime($finnishtime)));
        $finnishtime = date('H:i:s', strtotime('+' . (string) date('s', strtotime($movieTiTime)) . ' second',   strtotime($finnishtime)));

        $cin = RoomDBDAO::getCinemaByRoomId($roomId);
        $startimtime_15minOffset = date('H:i:s', strtotime('-15 minute',  strtotime($startimtime)));
        $finnishtime_15minOffset = date('H:i:s', strtotime('+15 minute',  strtotime($finnishtime)));

        $startimtimeCiin = date('H:i:s', strtotime($cin->getopeningTime()));
        $finnishtimeCin = date('H:i:s', strtotime($cin->getclosingTime()));

        /*buscar si chocan con los tiempos de cine*/
        if (strtotime($startimtimeCiin) >= strtotime($startimtime_15minOffset))
            array_push($exceptionArray, "The start of the function is earlier than the opening time");

        if (
            strtotime($cin->getclosingTime()) <= strtotime($finnishtime_15minOffset) ||
            strtotime($finnishtime) <= strtotime($startimtime)
        )
            array_push($exceptionArray, "The end of the function is later than the closing time");

        /*buscar si chocan con los tiempos de funciones*/
        if (FunctionsDAO::checkIfStartCollideWithFunctionInRoom($startimtime_15minOffset, $finnishtime_15minOffset, $roomId, $date, $functionId))
            array_push($exceptionArray, "This function collides with another function's start");

        if (FunctionsDAO::checkIfEndCollideWithFunctionInRoom($startimtime_15minOffset, $finnishtime_15minOffset, $roomId, $date, $functionId))
            array_push($exceptionArray, "This function collides with another function's end");
        /*problemas con los tiempos de funcion*/

        if (!empty($exceptionArray))
            throw new ArrayException("Error Processing Request", $exceptionArray, 1);

        else {
            $query = "
                update functions set time = :time, idMovie = :idMovie, idRoom = :idRoom, deleted = :deleted,
                finishTime = :finishTime, day = :day where id = :funid;";

            $param = [];
            $param['time'] = $startimtime;
            $param['idMovie'] = $movieId;
            $param['idRoom'] = $roomId;
            $param['deleted'] = 0;
            $param['finishTime'] = $finnishtime;
            $param['day'] = $date;
            $param['funid'] = $functionId;

            try {
                $conection = Connection::GetInstance();
                $response = $conection->ExecuteNonQuery($query, $param);
            } catch (PDOException $th) {
                throw $th;
            }
        }
    }

    public static function delete(int $id)
    {
        $query = "update functions set deleted = 1 where id = :id";
        $param = [];
        $param['id'] = $id;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->ExecuteNonQuery($query, $param);
        } catch (PDOException $th) {
            throw $th;
        }
    }

    public static function getAllFromRoom(int $id)
    {
        $query = "select * from functions where deleted = 0 and idRoom = :room";
        $param = [];
        $param['room'] = $id;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, $param);
        } catch (PDOException $th) {
            throw $th;
        }

        $roleArray = array_map(function (array $obj) {
            $funToReturn = new Functions();
            $funToReturn->setidFunction($obj['id']);
            $funToReturn->setTime((string) date('H:i:s', strtotime($obj['time'])));
            $funToReturn->setfinishTime((string) date('H:i:s', strtotime($obj['finishTime'])));
            $funToReturn->setDay((string) date('Y-m-d', strtotime($obj['day'])));
            $funToReturn->setMovie(MovieDAO::getMovieById($obj['idMovie']));
            $funToReturn->setidRoom($obj['idRoom']);
            $funToReturn->setDeleteFunction($obj['deleted']);

            return $funToReturn;
        }, $response);

        return $roleArray;
    }

    public static function getAllFromCinema(int $id)
    {
        $query = "
        select count(*) as cnt from (
        select functions.*, cinemas.idCinema from functions 
        inner join rooms on rooms.idRoom = functions.idRoom
        inner join cinemas on rooms.idCinema = cinemas.idCinema
        where functions.deleted = 0
        and cinemas.idCinema = :id
        group by cinemas.idCinema
        ) as x 
        having cnt > 0
        ";

        $param = [];
        $param['id'] = $id;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, $param);
        } catch (PDOException $th) {
            throw $th;
        }

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }
}
