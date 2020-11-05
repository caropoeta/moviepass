<?php

namespace DAO;

use Models\Genre;
use Models\Movie;
use PDO;
use PDOException;

class MovieDAO
{
    public static function deleteById(int $id)
    {
        try {
            $conection = Connection::GetInstance();
            $query = "update movies set deleted = :deleted where id = :id;";
            $conection->ExecuteNonQuery($query, array('id' => $id, 'deleted' => 1));
        } catch (PDOException $th) {
            throw $th;
        }
    }

    public static function checkMovieDeletedById(INT $id)
    {
        try {
            $conection = Connection::GetInstance();
            $query = "select true from movies where id = :id and deleted = :deleted;";
            $response = $conection->Execute($query, array('id' => $id, 'deleted' => 1));
        } catch (PDOException $th) {
            throw $th;
        }

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }

    public static function checkMovieById(int $id)
    {
        try {
            $conection = Connection::GetInstance();
            $query = "select true from movies where id = :id and deleted = 0;";
            $response = $conection->Execute($query, array('id' => $id));
        } catch (PDOException $th) {
            throw $th;
        }

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
        try {
            $conection = Connection::GetInstance();

            if (MovieDAO::checkMovieDeletedById($movie->getId())) {
                $query = "update movies set deleted = :deleted where id = :id;";
                $conection->ExecuteNonQuery($query, array('id' => $movie->getId(), 'deleted' => 0));
            } else if (!MovieDAO::checkMovieById($movie->getId())) {
                $query = "
                INSERT INTO `movies`(`id`, `title`, `release_date`, `vote_average`, `overview`, `poster_path`, runtime) 
                VALUES (:id, :title, :releaseDate, :points, :movieDescription, :poster, :runtime)";

                $params = [];
                $params['id']                   = $movie->getId();
                $params['title']                = $movie->getTitle();
                $params['releaseDate']          = $movie->getReleaseDate();
                $params['points']               = $movie->getPoints();
                $params['movieDescription']     = $movie->getDescription();
                $params['poster']               = $movie->getPoster();
                $params['runtime']              = $movie->getRuntime();

                $conection->ExecuteNonQuery(
                    $query,
                    $params
                );

                foreach ($movie->getGenres() as $value) {
                    if ($value instanceof Genre)
                        MovieXGenreDAO::addGenreIdToMovieId($value->getId(), $movie->getId());
                }
            }
        } catch (PDOException $th) {
            throw $th;
        }
    }
}
