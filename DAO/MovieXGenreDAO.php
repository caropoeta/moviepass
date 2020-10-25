<?php

namespace DAO;

use Models\Movie;

class MovieXGenreDAO
{
    public static function getMovies(int $page, String $title = "", int $year = 0, array $genresW = [], array $genresWO = [])
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

    public static function checkMovieById(int $id, array $currMovies)
    {
        foreach ($currMovies as $value) {
            if ($value instanceof Movie)
                if ($value->getId() == $id)
                    return true;
        }

        return false;
    }

    public static function getGenresByMovieId(int $id)
    {
        $conection = Connection::GetInstance();
        $query = "
        select idGenre from genresxmovies where idMovie = :id;";
        $response = $conection->Execute($query, array('id' => $id));

        $roleArray = array_map(function (array $obj) {
            return GenreDAO::getGenreById($obj['idGenre']);
        }, $response);

        return $roleArray;
    }

    public static function addGenreIdToMovieId(int $genreId, int $movieId)
    {
        GenreDAO::addGenre(ApiGenreDAO::getApiGenreById($genreId));

        $conection = Connection::GetInstance();
        $query = "
        INSERT INTO `genresxmovies`(`idMovie`, `idGenre`) 
        VALUES (:movieId, :genreId)";

        $params = [];
        $params['movieId']  = $movieId;
        $params['genreId']  = $genreId;

        $conection->ExecuteNonQuery(
            $query,
            $params
        );
    }
}
