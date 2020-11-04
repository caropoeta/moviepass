<?php

namespace DAO;

use PDOException;

class TicketDAO
{
    public static function getStatisticsFromMovie(int $idMov, String $strPeriod, String $endPeriod)
    {
    }

    public static function getStatisticsFromFunction(int $idFun)
    {
        $query = "
        select capacity, asists, asists * price as moneyRecolected
        from functions 
        inner join (
	    select idFunction , count(*) as asists from tickets group by tickets.idFunction
        ) as asistsPerFunction
        on asistsPerFunction.idFunction = functions.id
        inner join (
	    select idRoom, price, capacity from rooms group by idRoom
        ) as SeatsPerFunction
        on SeatsPerFunction.idRoom = functions.idRoom
        where (capacity - asists) > 0
        and deleted = 0
        and day > CAST(CURRENT_TIMESTAMP AS DATE)
        and functions.id = :idfunctions
        ";

        $params = [];
        $params['idfunctions'] = $idFun;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute(
                $query,
                $params
            );
        } catch (PDOException $ex) {
            throw $ex;
        }

        var_dump($response);
    }

    public static function getTicketsFromUser(int $idUser)
    {
    }

    public static function addTicket(int $idFunction, int $idUser)
    {
        $query = " 
        INSERT INTO tickets(idUser, idFunction, seatNumber)
        select :idUser,:idFunction, ifnull(max(seatNumber), 0) + 1
        from tickets
        where idFunction = :idFunction";
        $params = [];
        $params['idUser'] = $idUser;
        $params['idFunction'] = $idFunction;

        try {
            $conection = Connection::GetInstance();
            $conection->ExecuteNonQuery(
                $query,
                $params
            );
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    public static function getFunctionsAndCinemasFromMovies(int $idMovie)
    {
        $query = "
        select idRoomWithSeats.id, idRoomWithSeats.time, idRoomWithSeats.finishTime, idRoomWithSeats.day,
        cinemas.idCinema, cinemas.cinemaName, cinemas.address,
        rooms.price, rooms.roomName
        from (
        select functions.*
        from functions 
        left join (
	    select idFunction , count(*) as asists from tickets group by tickets.idFunction
        ) as asistsPerFunction
        on asistsPerFunction.idFunction = functions.id
        inner join (
	    select idRoom, capacity from rooms group by idRoom
        ) as SeatsPerFunction
        on SeatsPerFunction.idRoom = functions.idRoom
        where (capacity - ifnull(asists, 0)) > 0
        and deleted = 0
        and day > CAST(CURRENT_TIMESTAMP AS DATE)
        ) as idRoomWithSeats
        inner join rooms
        on idRoomWithSeats.idRoom = rooms.idRoom
        inner join cinemas
        on cinemas.idCinema = rooms.idCinema
        where idMovie = :idMov
        group by id             
        ";

        $param = [];
        $param['idMov'] = $idMovie;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, $param);
        } catch (PDOException $th) {
            throw $th;
        }

        return $response;
    }

    public static function getFunctionRoomAndCinemaDataFromFunctionId(int $idFunction)
    {
        $query = "
        select idRoomWithSeats.id, idRoomWithSeats.time, idRoomWithSeats.finishTime, idRoomWithSeats.day, idRoomWithSeats.idMovie,
        cinemas.idCinema, cinemas.cinemaName, cinemas.address,
        rooms.price, rooms.roomName
        from (
        select functions.*
        from functions 
        left join (
	    select idFunction , count(*) as asists from tickets group by tickets.idFunction
        ) as asistsPerFunction
        on asistsPerFunction.idFunction = functions.id
        inner join (
	    select idRoom, capacity from rooms group by idRoom
        ) as SeatsPerFunction
        on SeatsPerFunction.idRoom = functions.idRoom
        where (capacity - ifnull(asists, 0)) > 0
        and deleted = 0
        and day > CAST(CURRENT_TIMESTAMP AS DATE)
        ) as idRoomWithSeats
        inner join rooms
        on idRoomWithSeats.idRoom = rooms.idRoom
        inner join cinemas
        on cinemas.idCinema = rooms.idCinema
        where id = :idfun
        group by id             
        ";

        $param = [];
        $param['idfun'] = $idFunction;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, $param);
        } catch (PDOException $th) {
            throw $th;
        }

        if ($response != null && isset($response[0]))
            return $response[0];
    }

    public static function getMaxAviableTicketsFromFunction(int $idFunction)
    {
        $query = "
        select capacity - ifnull(asists, 0) as freeSeats
        from functions 
        left join (
            select idFunction , count(*) as asists from tickets group by tickets.idFunction
        ) as asistsPerFunction
        on asistsPerFunction.idFunction = functions.id
        inner join (
            select idRoom, capacity from rooms group by idRoom
        ) as SeatsPerFunction
        on SeatsPerFunction.idRoom = functions.idRoom
        where (capacity - ifnull(asists, 0)) > 0
        and deleted = 0
        and day > CAST(CURRENT_TIMESTAMP AS DATE)
        and functions.id = :idfun
        ";

        $param = [];
        $param['idfun'] = $idFunction;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, $param);
        } catch (PDOException $th) {
            throw $th;
        }

        if ($response != null && isset($response[0]))
            return $response[0]['freeSeats'];
    }
}
