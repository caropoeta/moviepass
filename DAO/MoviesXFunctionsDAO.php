<?php

namespace DAO;

use Exception;
use Models\Functions;
use Models\Movie;
use PDO;
use PDOException;

class MoviesXFunctionsDAO
{
    public static function getMoviesFromRoom(int $fun, int $page, String $title = "", int $year = 0, array $genresW = [], array $genresWO = [])
    {
        $query = "select * from movies";
        $param = [];
        $addToQuerry = [];

        if (!empty($genresW)) {
            $query = $query . " inner join ( 
                select genresxmovies.idMovie
                from genresxmovies";

            $subSubQ = [];
            foreach ($genresW as $value) {
                $query = $query . " inner join (
                    select idMovie
                    from genresxmovies 
                    where idGenre = :idGenre" . $value . "
                ) as idgxm" . $value . "
                on idgxm" . $value . ".idMovie = genresxmovies.idMovie ";

                $param['idGenre' . $value] = (int) $value;
            }

            $query = $query . "
            group by genresxmovies.idMovie
            ) as srch
            on movies.id = srch.idMovie ";
        }

        if ($title != "") {
            array_push($addToQuerry, "movies.title like :title");
            $param['title'] = '%' . $title . '%';
        }

        if ($year != 0) {
            array_push($addToQuerry, "year(movies.release_date) = :year");
            $param['year'] = $year;
        }

        if (!empty($genresWO)) {
            $subQ = "
            not exists (
                select * from (
                    select idMovie as id, idGenre 
                    from genresxmovies 
                    where";

            $subSubQ = [];
            foreach ($genresWO as $value) {
                array_push($subSubQ, 'idGenre = :idGenre' . $value);
                $param['idGenre' . $value] = (int) $value;
            }

            $subQ = $subQ . ' ' . implode(" or ", $subSubQ) .
                ") as x where x.id = movies.id
            )";

            array_push($addToQuerry, $subQ);
        }

        /** filtrado de funcion */
        $subQ = "
            exists (
                select * from (
                    select functions.idMovie as id 
                    from functions
                    where functions.idRoom = :funid
                    and functions.deleted = 0";

        $param['funid'] = $fun;

        $subQ = $subQ . ") as x where x.id = movies.id
            )";
        array_push($addToQuerry, $subQ);
        /** filtrado de funcion */

        if (!empty($addToQuerry))
            $query = $query . " where 
            " . implode(" and ", $addToQuerry);

        $movXpage = 60;
        $page *= $movXpage;
        $page -= $movXpage;

        $query = $query . " limit " . $page . ", " . $movXpage . ";";

        $conection = Connection::GetInstance();
        $response = $conection->Execute($query, $param);

        $roleArray = array_map(function (array $obj) {
            $movie = Movie::fromArray($obj);
            $movie->setGenres(MovieXGenreDAO::getGenresByMovieId($movie->getId()));
            return $movie;
        }, $response);

        return $roleArray;
    }

    public static function checkAviableSeatsForMovie(int $idMovie)
    {
        $query = "
        select capacity.tmCapacity - ifnull(ticketsSold, 0) as freeSeats, fMovie
        from (
            select functions.idMovie as fMovie, sum(capacity.capacity) as tmCapacity
            from functions 
            inner join (
                select capacity, idRoom from rooms
            ) as capacity
            on capacity.idRoom = functions.idRoom
            where functions.deleted = 0
            and day > CAST(CURRENT_TIMESTAMP AS DATE)
            group by fMovie
        ) as capacity
        left join (
            select fun.idMovie, fun.idRoom, sum(1) as ticketsSold
            from tickets
            inner join (
            select * from functions
                where functions.deleted = 0
            ) as fun
            on tickets.idFunction = fun.id
            group by fun.idMovie
        ) as ticketsSold
        on ticketsSold.idMovie = capacity.fMovie
        where fMovie = :idMov";
        $param = [];
        $param['idMov'] = $idMovie;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, $param);
        } catch (PDOException $th) {
            throw $th;
        }

        $roleArray = array_map(function (array $obj) {
            return $obj['freeSeats'];
        }, $response);

        if ($roleArray != null)
            if ((sizeof($roleArray) > 0) ? true : false)
                return (((int) $roleArray[0]) > 0) ? true : false;
    }

    public static function getMoviesFromFunctions(int $page, String $title = "", int $year = 0, array $genresW = [], array $genresWO = [])
    {
        $query = "select * from movies";
        $param = [];
        $addToQuerry = [];

        if (!empty($genresW)) {
            $query = $query . " inner join ( 
                select genresxmovies.idMovie
                from genresxmovies";

            $subSubQ = [];
            foreach ($genresW as $value) {
                $query = $query . " inner join (
                    select idMovie
                    from genresxmovies 
                    where idGenre = :idGenre" . $value . "
                ) as idgxm" . $value . "
                on idgxm" . $value . ".idMovie = genresxmovies.idMovie ";

                $param['idGenre' . $value] = (int) $value;
            }

            $query = $query . "
            group by genresxmovies.idMovie
            ) as srch
            on movies.id = srch.idMovie ";
        }

        if ($title != "") {
            array_push($addToQuerry, "movies.title like :title");
            $param['title'] = '%' . $title . '%';
        }

        if ($year != 0) {
            array_push($addToQuerry, "year(movies.release_date) = :year");
            $param['year'] = $year;
        }

        if (!empty($genresWO)) {
            $subQ = "
            not exists (
                select * from (
                    select idMovie as id, idGenre 
                    from genresxmovies 
                    where";

            $subSubQ = [];
            foreach ($genresWO as $value) {
                array_push($subSubQ, 'idGenre = :idGenre' . $value);
                $param['idGenre' . $value] = (int) $value;
            }

            $subQ = $subQ . ' ' . implode(" or ", $subSubQ) .
                ") as x where x.id = movies.id
            )";

            array_push($addToQuerry, $subQ);
        }

        /** filtrado de funcion */
        $subQ = "
            exists (
                select * from (
                    select functions.idMovie as id 
                    from functions 
                    where functions.deleted = 0
                    and functions.day > :date";
        $subQ = $subQ . ") as x where x.id = movies.id
            )";

        $param['date'] = (string) date('Y/m/d', time());


        array_push($addToQuerry, $subQ);
        /** filtrado de funcion */

        if (!empty($addToQuerry))
            $query = $query . " where 
            " . implode(" and ", $addToQuerry);

        $movXpage = 60;
        $page *= $movXpage;
        $page -= $movXpage;

        $query = $query . " limit " . $page . ", " . $movXpage . ";";

        $conection = Connection::GetInstance();
        $response = $conection->Execute($query, $param);

        $roleArray = array_map(function (array $obj) {
            $movie = Movie::fromArray($obj);
            $movie->setGenres(MovieXGenreDAO::getGenresByMovieId($movie->getId()));
            return $movie;
        }, $response);

        return $roleArray;
    }
}
