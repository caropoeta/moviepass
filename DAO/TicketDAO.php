<?php

namespace DAO;

use Models\Ticket;
use PDOException;

class TicketDAO
{
    public static function getStatisticsFromMovie(int $idMov, String $strPeriod, String $endPeriod)
    {
        $query = "
        select sum(capacity) as totCapacity, sum(moneyRecolected) as totMoneyRecolected, sum(asists) as totAsists from
        (select capacity, ifnull(asists, 0) as asists, ifnull(asists, 0) * price as moneyRecolected, functions.day
        from functions 
        left join (
	    select idFunction , count(*) as asists from tickets group by tickets.idFunction
        ) as asistsPerFunction
        on asistsPerFunction.idFunction = functions.id
        inner join (
	    select idRoom, price, capacity from rooms group by idRoom
        ) as SeatsPerFunction
        on SeatsPerFunction.idRoom = functions.idRoom
        where functions.idMovie = :idMov" .
            (($strPeriod != null) && ($endPeriod != null)) ? " and functions.day between :strPeriod and :endPeriod" : ''
            . ") as moviedata
        ";

        $params = [];
        $params['idMov'] = $idMov;
        $params['strPeriod'] = $strPeriod;
        $params['endPeriod'] = $endPeriod;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute(
                $query,
                $params
            );
        } catch (PDOException $ex) {
            throw $ex;
        }

        if ($response != null && isset($response[0]))
            return $response[0];
    }

    public static function getStatisticsFromFunction(int $idFun)
    {
        $query = "
        select capacity, ifnull(asists, 0) as asists, ifnull(amount, 0) as moneyRecolected

        from functions 
        
        left join (
			select idFunction , count(*) as asists from tickets group by tickets.idFunction
        ) as asistsPerFunction
        on asistsPerFunction.idFunction = functions.id
        
        inner join rooms
        on rooms.idRoom = functions.idRoom
        
        left join (
			select idFunction, sum(amount) as amount from tickets #where tickets.idFunction
            inner join purchase
            on purchase.id = tickets.idPayment
            group by tickets.idFunction
        ) as moneyRecolected
        on moneyRecolected.idFunction = functions.id
        where functions.id = :idfunction
        ";

        $params = [];
        $params['idfunction'] = $idFun;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute(
                $query,
                $params
            );
        } catch (PDOException $ex) {
            throw $ex;
        }

        if ($response != null && isset($response[0]))
            return $response[0];
    }

    public static function getTicketsFromUser(int $idUser, String $movieName = "", String $date = "")
    {
        $query = " 
        select tickets.*, functions.day, movies.title, rooms.roomName
        from tickets
        inner join functions
        on functions.id = tickets.idFunction
        inner join movies
        on movies.id = functions.idMovie
        inner join rooms
        on rooms.idRoom = functions.idRoom
        where idUser = :idUser
        ";

        $params = [];
        $params['idUser'] = $idUser;

        if ($movieName != "") {
            $query = $query . 'and movies.title like :title';
            $params['title'] = '%' . $movieName . '%';
        }

        if ($date != "") {
            $query = $query . 'and functions.day = :day';
            $params['day'] = $date;
        }

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute(
                $query,
                $params
            );
        } catch (PDOException $ex) {
            throw $ex;
        }

        return array_map(function (array $obj) {
            $tickToReturn = new Ticket();
            $tickToReturn->setId($obj['id']);
            $tickToReturn->setFunctionName($obj['roomName']);
            $tickToReturn->setSeat($obj['seatNumber']);
            $tickToReturn->setMovieTitle($obj['title']);
            $tickToReturn->setDate($obj['day']);

            $qr =
                "Ticket id: " . $obj['id'] .
                ", Room name: " . $obj['roomName'] .
                ", Seat number: " . $obj['seatNumber'] .
                ", Movie title: " . $obj['title'] .
                ", Function date: " . $obj['day'];

            $tickToReturn->setQr(GoogleQRDAO::GetQrImgUrl($qr));


            return $tickToReturn;
        }, $response);
    }

    public static function addTicket(int $idFunction, int $idUser, int $purchaseId)
    {
        $query = " 
        INSERT INTO tickets(idUser, idFunction, idPayment, seatNumber)
        select :idUser,:idFunction, :idPayment, ifnull(max(seatNumber), 0) + 1
        from tickets
        where idFunction = :idFunction";
        $params = [];
        $params['idUser'] = $idUser;
        $params['idFunction'] = $idFunction;
        $params['idPayment'] = $purchaseId;

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
