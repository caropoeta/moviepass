public static function getMovies(int $page, String $title = "", int $year = 0, Array $genresW = [], Array $genresWO = [])
    {
        $wGenres_ =  '';
        $woGenres_ = '';
        $year_ = '';
    
        /*
        if (!empty($genresW)) {
            $wGenres_ = "&with_genres=" . implode(',', $genresW);

            foreach ($variable as $key => $value) {
                # code...
            }
        }
        */
        /*
        if (!empty($genresWO))
          $woGenres_ = "&without_genres=" . implode(',', $genresWO);
    
        if ($year > 0) {
          $dateObj = \DateTime::createFromFormat("Y", $year);
          if (!$dateObj)
            throw new \UnexpectedValueException("Could not parse the date: " . $year);
    
          $year_ = "&year=" . $dateObj->format("Y");
        }
        */
        
        $conection = Connection::GetInstance();
        $query = "select * from movies;";

       /* 
        $params = [];
        $params['id']               = $movie->getId();
        $params['title']            = $movie->getTitle();
        $params['releaseDate']      = $movie->getReleaseDate();
        $params['points']           = $movie->getPoints();
        $params['movieDescription'] = $movie->getDescription();
        $params['poster']           = $movie->getPoster();
        */

        $response = $conection->Execute($query, []);

        $roleArray = array_map(function (array $obj) {
            $movie = Movie::fromArray($obj);
            $movie->setGenres(MovieXGenreDAO::getGenresByMovieId($movie->getId()));
            return $movie;
        }, $response);

        return $roleArray;
    }