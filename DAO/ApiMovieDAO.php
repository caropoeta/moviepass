<?php

namespace DAO;

use ErrorException;
use Exception;
use Models\Movie as Movie;
use Models\Genre as Genre;

class ApiMovieDAO
{
  public static function getApiMoviePage(int $page)
  {
    try {
      set_error_handler(
        function ($severity, $message, $file, $line) {
          throw new ErrorException($message, $severity, $severity, $file, $line);
        }
      );

      $response = file_get_contents(
        "https://api.themoviedb.org/3/movie/now_playing?page=" . $page . "&language=en-US&api_key=" . API_KEY
      );
      $jsonresponse = (array) json_decode($response,  true);
    } catch (Exception $e) {
      throw new Exception('Themoviedb API returned an error: ' . $e->getMessage(), 1);
    } finally {
      restore_error_handler();
    }

    if (isset($jsonresponse['success']) && $jsonresponse['success'] === false) {
      return [];
    } else {
      $jsonresponse = ($jsonresponse) ? $jsonresponse : [];
      return array_map(function (array $moviearr) {
        $movie = Movie::fromArray($moviearr);

        $genrearr = [];
        foreach ($moviearr['genre_ids'] as $genre) {
          array_push($genrearr, ApiGenreDAO::getApiGenreById($genre));
        }

        $movie->setGenres($genrearr);
        return $movie;
      }, $jsonresponse['results']);
    }
  }

  public static function getApiMovieSearchByName(int $page, String $name)
  {
    $name = urlencode($name);

    try {
      set_error_handler(
        function ($severity, $message, $file, $line) {
          throw new ErrorException($message, $severity, $severity, $file, $line);
        }
      );
      $response = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=" . API_KEY . "&language=en-US&query=" . $name . "&page=" . $page . "&include_adult=true");
      $jsonresponse = (array) json_decode($response,  true);
    } catch (Exception $e) {
      throw new Exception('Themoviedb API returned an error: ' . $e->getMessage(), 1);
    } finally {
      restore_error_handler();
    }

    if (isset($jsonresponse['success']) && $jsonresponse['success'] === false) {
      return [];
    } else {
      $jsonresponse = ($jsonresponse) ? $jsonresponse : [];

      return array_map(function (array $moviearr) {
        $movie = Movie::fromArray($moviearr);

        $genrearr = [];
        foreach ($moviearr['genre_ids'] as $genre) {
          array_push($genrearr, ApiGenreDAO::getApiGenreById($genre));
        }
        $movie->setGenres($genrearr);

        return $movie;
      }, $jsonresponse['results']);
    }
  }

  public static function getApiMovieSearchByDateAndGenre(int $page, int $year, array $wGenres, array $woGenres)
  {
    $wGenres_ =  '';
    $woGenres_ = '';
    $year_ = '';

    if (!empty($wGenres))
      $wGenres_ = "&with_genres=" . implode(',', $wGenres);

    if (!empty($woGenres))
      $woGenres_ = "&without_genres=" . implode(',', $woGenres);

    if ($year > 0) {
      $dateObj = \DateTime::createFromFormat("Y", $year);
      if (!$dateObj)
        throw new \UnexpectedValueException("Could not parse the date: " . $year);

      $year_ = "&year=" . $dateObj->format("Y");
    }

    try {
      set_error_handler(
        function ($severity, $message, $file, $line) {
          throw new ErrorException($message, $severity, $severity, $file, $line);
        }
      );
      $response = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=" . API_KEY . "&language=en-US&sort_by=popularity.desc&page=" . $page . $year_ . $wGenres_ . $woGenres_);
      $jsonresponse = (array) json_decode($response,  true);
    } catch (Exception $e) {
      throw new Exception('Themoviedb API returned an error: ' . $e->getMessage(), 1);
    } finally {
      restore_error_handler();
    }

    if (isset($jsonresponse['success']) && $jsonresponse['success'] === false) {
      return [];
    } else {
      $jsonresponse = ($jsonresponse) ? $jsonresponse : [];
      return array_map(function (array $moviearr) {
        $movie = Movie::fromArray($moviearr);

        $genrearr = [];
        foreach ($moviearr['genre_ids'] as $genre) {
          array_push($genrearr, ApiGenreDAO::getApiGenreById($genre));
        }

        $movie->setGenres($genrearr);
        return $movie;
      }, $jsonresponse['results']);
    }
  }

  public static function getApiMovieById(int $id)
  {
    try {
      set_error_handler(
        function ($severity, $message, $file, $line) {
          throw new ErrorException($message, $severity, $severity, $file, $line);
        }
      );

      $response = file_get_contents("https://api.themoviedb.org/3/movie/" . $id . "?api_key=" . API_KEY . "&language=en-US");
      $jsonresponse = (array) json_decode($response,  true);
    } catch (Exception $th) {
      return null;
    } finally {
      restore_error_handler();
    }

    if (isset($jsonresponse['success']) && $jsonresponse['success'] === false) {
      return [];
    } else {
      $jsonresponse = ($jsonresponse) ? $jsonresponse : [];

      $jsonresponse["runtime"] = (string) date('H:i:s', mktime(0, $jsonresponse["runtime"]));

      $movie = Movie::fromArray($jsonresponse);

      $genrearr = [];
      foreach ($jsonresponse['genres'] as $genre) {
        array_push($genrearr, ApiGenreDAO::getApiGenreById($genre['id']));
      }

      $movie->setGenres($genrearr);
      return $movie;
    }
  }
}
