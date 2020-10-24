<?php

namespace DAO;

use Models\Genre;
use Models\Movie;

class MovieDAO
{
    public static function checkMovieById(int $id)
    {
        $conection = Connection::GetInstance();
        $query = "select true from movies where id = :id;";
        $response = $conection->Execute($query, array('id' => $id));

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }

    public static function getMovieById(int $id)
    {
        $conection = Connection::GetInstance();
        $query = "
        select * from movies where id = :id;";
        $response = $conection->Execute($query, array('id' => $id));

        $roleArray = array_map(function (array $obj) {
            $movie = Movie::fromArray($obj);
            $movie->setGenres(MovieXGenreDAO::getGenresByMovieId($movie->getId()));
            return $movie;
        }, $response);

        return ((isset($roleArray[0])) ? $roleArray[0] : null);
    }

    public static function addMovie(Movie $movie)
    {
        if (!MovieDAO::checkMovieById($movie->getId())) {
            $conection = Connection::GetInstance();
            $query = "
            INSERT INTO `movies`(`id`, `title`, `release_date`, `vote_average`, `overview`, `poster_path`) 
            VALUES (:id, :title, :releaseDate, :points, :movieDescription, :poster)";

            $params = [];
            $params['id']               = $movie->getId();
            $params['title']            = $movie->getTitle();
            $params['releaseDate']      = $movie->getReleaseDate();
            $params['points']           = $movie->getPoints();
            $params['movieDescription'] = $movie->getDescription();
            $params['poster']           = $movie->getPoster();

            $conection->ExecuteNonQuery(
                $query,
                $params
            );

            foreach ($movie->getGenres() as $value) {
                if ($value instanceof Genre)
                    MovieXGenreDAO::addGenreIdToMovieId($value->getId(), $movie->getId());
            }
        }
    }
}
