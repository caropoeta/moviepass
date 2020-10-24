<?php

namespace Models;

use Exception;

class Movie
{
    private $title;
    private $releaseDate;
    private $points;
    private $description;
    private $poster;
    private $movieId;
    private $genres;

    public function __construct
    (
        String $title,
        $releaseDate,
        int $points,
        String $description,
        String $poster,
        int $movieId,
        Array $genres
    ) {
        $this->setTitle($title);
        $this->setReleaseDate($releaseDate);
        $this->setPoints($points);
        $this->setDescription($description);
        $this->setPoster($poster);
        $this->setId($movieId);
        $this->setGenres($genres);
    }

    public static function fromArray(array $obj)
    {
        if(!isset($obj["release_date"]))
            $obj["release_date"] = 0000-00-00;

        try {
            return new Movie(
                (String)    $obj["title"],
                            $obj["release_date"],
                (int)       $obj["vote_average"],
                (string)    $obj["overview"],
                (string)    $obj["poster_path"],
                (int)       $obj["id"],
                []
            );
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function setTitle(String $title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }
    public function setPoints(int $points)
    {
        $this->points = $points;
    }

    public function getPoints()
    {
        return $this->points;
    }
    public function setDescription(String $description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setPoster(String $poster)
    {
        $this->poster = $poster;
    }

    public function getPoster()
    {
        return $this->poster;
    }

    public function setId(int $movieId)
    {
        $this->movieId = $movieId;
    }

    public function getId()
    {
        return $this->movieId;
    }

    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;
    }

    public function getRuntime()
    {
        return $this->runtime;
    }

    public function setGenres(array $genres)
    {
        $this->genres = $genres;
    }

    public function getGenres()
    {
        return $this->genres;
    }
}
