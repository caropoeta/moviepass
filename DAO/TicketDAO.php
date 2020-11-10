<?php

namespace DAO;

use Models\Statistics;
use Models\Ticket;
use PDOException;

class TicketDAO
{
    public static function getStatisticsFromCinema(int $idCinema, String $strPeriod = "", String $endPeriod = "")
    {
        $query = "
        select
  cinStatistics.cinemaName,
  cinStatistics.idCinema,
  sum(capacity) as totCapacity,
  sum(moneyRecolected) as totMoneyRecolected,
  sum(asists) as totAsists
from
  (
    select
      cinemas.cinemaName,
      cinemas.idCinema,
      ifnull(functionsStatistics.capacity, 0) as capacity,
      ifnull(asists, 0) as asists,
      ifnull(amount, 0) as moneyRecolected,
      day
    from
      cinemas
      left join (
        select
          functions.id,
          functions.idMovie,
          functions.day,
          rooms.capacity,
          rooms.roomName,
          rooms.idCinema,
          ifnull(purchase.amount, 0) as amount,
          ifnull(count(tickets.id), 0) as asists
        from
          functions
          inner join rooms on rooms.idRoom = functions.idRoom
          left join tickets on tickets.idFunction = functions.id
          left join (
            select
              sum(amount) as amount,
              idFunction as idFunctionPay
            from
              (
                select
                  purchase.*,
                  tickets.idFunction
                from
                  purchase
                  inner join tickets on tickets.idPayment = purchase.id
                group by
                  purchase.id
              ) as payment
            group by
              payment.idFunction
          ) as purchase on purchase.idFunctionPay = functions.id
        ";

        $params = [];

        if ($strPeriod != "" && $endPeriod != "") {
            $query = $query . "
            where
            day between :strPeriod
            and :endPeriod
            ";

            $params['strPeriod'] = $strPeriod;
            $params['endPeriod'] = $endPeriod;
        }

        $query = $query . "     
                    
        group by
        functions.id
    ) as functionsStatistics on functionsStatistics.idCinema = cinemas.idCinema
) as cinStatistics
where
idCinema = :idCinema
group by
cinStatistics.idCinema
        ";

        $params['idCinema'] = $idCinema;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute(
                $query,
                $params
            );
        } catch (PDOException $ex) {
            throw $ex;
        }

        if (! empty($response)) {
            $stats = new Statistics();
            $stats->setCinemaName($response[0]['cinemaName']);
            $stats->setTicketsSold($response[0]['totAsists']);
            $stats->setRevenue($response[0]['totMoneyRecolected']);
            $stats->setUnsoldTickets($response[0]['totCapacity'] - $response[0]['totAsists']);
            $stats->setStartDate($strPeriod);
            $stats->setFinishDate($endPeriod);
            
            return $stats;
        } else
            return false;
    }

    public static function getStatisticsFromMovie(int $idMov, String $strPeriod = "", String $endPeriod = "")
    {
        $query = "
        select
  movStatistics.title,
  movStatistics.id,
  sum(capacity) as totCapacity,
  sum(moneyRecolected) as totMoneyRecolected,
  sum(asists) as totAsists
from
  (
    select
      movies.title,
      ifnull(capacity, 0) as capacity,
      movies.id,
      ifnull(asists, 0) as asists,
      ifnull(amount, 0) as moneyRecolected,
      day
    from
      movies
      left join (
        select
          functions.id,
          functions.idMovie,
          functions.day,
          rooms.capacity,
          rooms.roomName,
          ifnull(purchase.amount, 0) as amount,
          ifnull(count(tickets.id), 0) as asists
        from
          functions
          inner join rooms on rooms.idRoom = functions.idRoom
          left join tickets on tickets.idFunction = functions.id
          left join (
            select
              sum(amount) as amount,
              idFunction as idFunctionPay
            from
              (
                select
                  purchase.*,
                  tickets.idFunction
                from
                  purchase
                  inner join tickets on tickets.idPayment = purchase.id
                group by
                  purchase.id
              ) as payment
            group by
              payment.idFunction
          ) as purchase on purchase.idFunctionPay = functions.id
        ";

        $params = [];

        if ($strPeriod != "" && $endPeriod != "") {
            $query = $query . "
            where
            day between :strPeriod
            and :endPeriod
            ";

            $params['strPeriod'] = $strPeriod;
            $params['endPeriod'] = $endPeriod;
        }

        $query = $query . "     
                    group by
                functions.id
            ) as functionsStatistics on functionsStatistics.idMovie = movies.id
        ) as movStatistics
        where
        id = :idMovie
        group by
        movStatistics.id
        ";

        $params['idMovie'] = $idMov;

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

    public static function getTicketsFromUser(
        int $idUser,
        String $movieName = "",
        String $date = "",
        String $orderby = ""
    ) {
        $query = " 
        select tickets.*, functions.day, movies.title, rooms.roomName, cinemaName, functions.time
        from tickets
        inner join functions
        on functions.id = tickets.idFunction
        inner join movies
        on movies.id = functions.idMovie
        inner join rooms
        on rooms.idRoom = functions.idRoom
        inner join cinemas
        on rooms.idCinema = cinemas.idCinema
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

        if ($orderby != "") {
            switch ($orderby) {
                case 'mta':
                    $query = $query . ' order by title asc';
                    break;

                case 'mtd':
                    $query = $query . ' order by title desc';
                    break;

                case 'cna':
                    $query = $query . ' order by cinemaName asc';
                    break;

                case 'cnd':
                    $query = $query . ' order by cinemaName desc';
                    break;

                default:
                    break;
            }
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
            $tickToReturn->setCinemaName($obj['cinemaName']);
            $tickToReturn->setHour($obj['time']);

            $qr =
                "Ticket id: " . $obj['id'] .
                ", Cinema name: " . $obj['cinemaName'] .
                ", Room name: " . $obj['roomName'] .
                ", Seat number: " . $obj['seatNumber'] .
                ", Movie title: " . $obj['title'] .
                ", Function date: " . $obj['day'] .
                ", Function hour: " . $obj['time'] .
                ".";

            $tickToReturn->setQr(GoogleQRDAO::GetQrImgUrl($qr));


            return $tickToReturn;
        }, $response);
    }

    public static function getTicketsFromUserPurchase(
        int $idUser,
        int $purchaseId
    ) {
        $query = " 
        select tickets.*, functions.day, movies.title, rooms.roomName, cinemaName, functions.time
        from tickets
        inner join functions
        on functions.id = tickets.idFunction
        inner join movies
        on movies.id = functions.idMovie
        inner join rooms
        on rooms.idRoom = functions.idRoom
        inner join cinemas
        on rooms.idCinema = cinemas.idCinema
        where idUser = :idUser
        and idPayment = :purchaseId
        ";

        $params = [];
        $params['idUser'] = $idUser;
        $params['purchaseId'] = $purchaseId;

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
            $tickToReturn->setCinemaName($obj['cinemaName']);
            $tickToReturn->setHour($obj['time']);

            $qr =
                "Ticket id: " . $obj['id'] .
                ", Cinema name: " . $obj['cinemaName'] .
                ", Room name: " . $obj['roomName'] .
                ", Seat number: " . $obj['seatNumber'] .
                ", Movie title: " . $obj['title'] .
                ", Function date: " . $obj['day'] .
                ", Function hour: " . $obj['time'] .
                ".";

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
