<?php

namespace DAO;

use Models\Movie as Movie;
use Models\Genere as Genere;

class ApiDAO
{
  public static function getApiMoviePage($page, array $generes)
  {
    $response = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?page=" . $page . "&language=en-US&api_key=" . API_KEY);
    $jsonresponse = (array) json_decode($response,  true);

    if (isset($jsonresponse['success']) && $jsonresponse['success'] === false) {
      return [];
    } else {
      $jsonresponse = ($jsonresponse) ? $jsonresponse : [];
      $movies = array();
      foreach ($jsonresponse['results'] as $k => $v) {
        $movie = new Movie();
        $movie->setTitle($v['title']);
        $movie->setReleaseDate($v['release_date']);
        $movie->setPoints($v['vote_average']);
        $movie->setDescription($v['overview']);
        $movie->setPoster($v['poster_path']);
        $movie->setId($v['id']);

        $genresArray = [];
        $responseGenereArray = $v['genre_ids'];
        foreach ($responseGenereArray as $genre) {
          array_push($genresArray, ApiDAO::getApiGenereById($genre, $generes));
        }

        $movie->setGenres($genresArray);

        array_push($movies, $movie);
      }

      return $movies;
    }
  }

  public static function getApiGeneres()
  {
    $response = file_get_contents('https://api.themoviedb.org/3/genre/movie/list?api_key=' . API_KEY . '&language=en-US');
    $jsonresponse = (array) json_decode($response, true);

    if (isset($jsonresponse['success']) && $jsonresponse['success'] === false) {
      return [];
    } else {
      $jsonresponse = ($jsonresponse) ? $jsonresponse : array();
      $generes = [];
      foreach ($jsonresponse['genres'] as $v) {
        $genre = new Genere();
        $genre->setId($v['id']);
        $genre->setDescription($v['name']);
        array_push($generes, $genre);
      }
      return $generes;
    }
  }

  public static function getApiGenereById(int $id, array $generes)
  {
    $toReturn = 'Genere';
    foreach ($generes as $value) {
      if ($value instanceof Genere) {
        if ($value->getId() == $id) {
          $toReturn = $value->getDescription();
        }
      }
    }

    return $toReturn;
  }
}
