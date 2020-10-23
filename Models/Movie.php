<?php namespace Models;
class Movie {
    
    private $title;
    private $releaseDate;
    private $points;
    private $description;
    private $poster;
    private $movieId;
    private $genres;

    public function setTitle($title){
        $this->title = $title ;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setReleaseDate($releaseDate){
        $this->releaseDate = $releaseDate ;
    }

    public function getReleaseDate(){
        return $this->releaseDate ;
    }
    public function setPoints($points){
        $this->points = $points ;
    }

    public function getPoints (){
        return $this->points ;
    }
    public function setDescription($description){
        $this->description = $description ;
    }

    public function getDescription(){
        return $this->description ;
    }
    public function setPoster($poster){
        $this->poster = $poster ;
    }

    public function getPoster(){
        return $this->poster;
    }

    public function setId($movieId){
        $this->movieId = $movieId;
    }

    public function getId(){
        return $this->movieId;
    }

    public function setRuntime($runtime){
        $this->runtime = $runtime;
    }

    public function getRuntime(){
        return $this->runtime;
    }

    public function setGenres($genres){
        $this->genres = $genres;
    }

    public function getGenres(){
        return $this->genres;
    }

}