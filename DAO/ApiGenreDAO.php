<?php

namespace DAO;

use Models\Genre as Genre;

class ApiGenreDAO
{
    private static $genres = null;

    public static function getApiGenres()
    {
        if (empty(self::$genres)) {
            $response = file_get_contents('https://api.themoviedb.org/3/genre/movie/list?api_key=' . API_KEY . '&language=en-US');
            $jsonresponse = (array) json_decode($response, true);

            if (isset($jsonresponse['success']) && $jsonresponse['success'] === false) {
                self::$genres = [];
            } else {
                $jsonresponse = ($jsonresponse) ? $jsonresponse : array();

                self::$genres = array_map(function (array $genre) {
                    return Genre::fromArray($genre);
                }, $jsonresponse['genres']);
            }
        }

        return self::$genres;
    }

    public static function getApiGenreById(int $id)
    {
        $toReturn = 'Genere';
        foreach (ApiGenreDAO::getApiGenres() as $value) {
            if ($value instanceof Genre) {
                if ($value->getId() == $id) {
                    $toReturn = $value;
                }
            }
        }

        return $toReturn;
    }

    public static function getApiGenreByName(String $name)
    {
        $toReturn = 'Genere';
        foreach (ApiGenreDAO::getApiGenres() as $value) {
            if ($value instanceof Genre) {
                if ($value->getDescription() == $name) {
                    $toReturn = $value;
                }
            }
        }

        return $toReturn;
    }
}
