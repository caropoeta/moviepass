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
    private $runtime;

    public function __construct(
        String $title,
        $releaseDate,
        int $points,
        String $description,
        String $poster,
        int $movieId,
        array $genres,
        String $runtime
    ) {
        $this->setTitle($title);
        $this->setReleaseDate($releaseDate);
        $this->setPoints($points);
        $this->setDescription($description);
        $this->setPoster($poster);
        $this->setId($movieId);
        $this->setGenres($genres);
        $this->setRuntime($runtime);
    }

    public static function fromArray(array $obj)
    {
        if (!isset($obj["release_date"]))
            $obj["release_date"] = '0000-00-00';

        if (!isset($obj["runtime"]))
            $obj["runtime"] = '00:00:00';

        else if ($obj["runtime"] == "0")
            $obj["runtime"] = '00:00:00';

        try {
            return new Movie(
                (string)    $obj["title"],
                $obj["release_date"],
                (int)       $obj["vote_average"],
                (string)    $obj["overview"],
                (string)    $obj["poster_path"],
                (int)       $obj["id"],
                [],
                (String)    $obj['runtime']

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

    public function setRuntime(String $runtime)
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
