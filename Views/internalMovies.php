<section>
     <?php
     include('navbaradmin.php');

     use DAO\GenreDAO;
     use DAO\MovieDAO;
     use Models\Genre;
     use Models\Movie as Movie;
     ?>
</section>

<section id="listado" class="mb-5">
     <h2 class="title-secondary">Movie List</h2>
     <div class="container-fluid">

          <br>
          <div >
               <div class="form-group-movies">
                   <h3>Choose an option to filter</h3> 
                   <br>
                   <div class="container-movies">
                        <small style="color:black" class="offset-5">
                         *Search either by name or date and genres.
                         </small>

                    <form method="POST">
                         <div>   
                              <div class="form-group">
                                   <input type="text" class="form-group" name="name" placeholder="Enter movie name" value="<?php echo $name ?>">
                              </div>
                              
                              <div class="form-check">
                                   <small style="color:black">
                                        *Search with genres.
                                   </small>
                                   <br>
                                   <input type='hidden' name='genre-with' value="[]" />
                                   <?php foreach ($genres as $value) {
                                        if ($value instanceof Genre) {
                                             ?>
                                             
                                             <input <?php if (in_array($value->getId(), $genreW)) echo 'checked' ?> type="checkbox" class="form-check-input" id="gnr<?php echo $value->getId() ?>" name="genre-with[]" value="<?php echo $value->getId() ?>">
                                             <label class="form-check-label" for="gnr<?php echo $value->getId() ?>"> <?php echo $value->getDescription() ?></label><br>
                                             <?php
                                        }
                                   } ?>
                              </div>
                              <br>
                              <div class="form-check">
                                   <small style="color:black">
                                        *Search without genres.
                                   </small>
                                   <br>
                                   <input type='hidden' name='genre-without' value="[]" />
                                   <?php foreach ($genres as $value) {
                                        if ($value instanceof Genre) {
                                             ?>
                                              <input <?php if (in_array($value->getId(), $genreWO)) echo 'checked' ?> type="checkbox" class="form-check-input" id="gnrO<?php echo $value->getId() ?>" name="genre-without[]" value="<?php echo $value->getId() ?>">
                                              
                                             <label class="form-check-label" for="gnr<?php echo $value->getId() ?>"> <?php echo $value->getDescription() ?></label><br>
                                             <?php
                                        }
                                   } ?>
                              </div>

                              <br>
                              <div class="form-group">
                              <small style="color:black" >
                         *Search by year.
                    </small>
                                   <input type="number" min="1582" max="9999" class="form-group" name="year" placeholder="Enter movie year of release" value=<?php echo $year ?>>
                              </div>
                              <div class="align-items-center">
                                   <button class="botons" formaction="<?php echo FRONT_ROOT ?>Movies/List/" name="page" value="1" type="submit">Search</button>
                              </div>
                         </div>
                    </div>
               </div>
               </div>
                   
               </form>
         
      </div>
      <br>
       <hr>
               <div class="align-items-center">
                    <button class="botons-chico" style="margin-left: 25%"  formaction="<?php echo FRONT_ROOT ?>Movies/List/" type="submit" name="page" value="<?php echo $currPage - 1 ?>">Back Page</button>
                    <button class="botons-chico"  formaction="<?php echo FRONT_ROOT ?>Movies/List/" type="submit" name="page" value="<?php echo $currPage + 1 ?>">Next Page</button>
               </div>
          
    
     <div class=col-auto>
          <div class="">
               <form method="POST">
                    <table class="table bg-light">
                         <thead class="bg-dark text-white">
                              <th>Title</th>
                              <th>Description</th>
                              <th>Genres</th>
                              <th>Movie Photo</th>
                              <th></th>
                         </thead>
                         <tbody>
                              <?php

                              foreach ($movies as $movie) {
                                   if ($movie instanceof Movie) { ?>
                                        <tr>
                                             <td><?php echo $movie->getTitle(); ?></td>
                                             <td><?php echo $movie->getDescription(); ?></td>
                                             <td><?php
                                             foreach ($movie->getGenres() as $value) {
                                                  if ($value instanceof Genre)
                                                       echo $value->getDescription() . '<br>';
                                             }
                                             ?></td>
                                             <td><?php if ($movie->getPoster() != null) {
                                                  echo '<img src="https://image.tmdb.org/t/p/w500' . $movie->getPoster() . '" width="100" height="147">';
                                             } ?></td>
                                             <td>
                                                  <div class="col-auto">
                                                       <?php if (!MovieDAO::checkMovieDeletedById($movie->getId())) { ?>
                                                            <div class="justify-content-center">
                                                            <input type="checkbox" class="form-check-input" id="mov<?php echo $movie->getId() ?>" name="mov[]" value="<?php echo $movie->getId() ?>">
                                                            <label class="form-check-label" for="mov<?php echo $movie->getId() ?>">Delete</label><br>
                                                       <?php } ?>
                                                  </div>
                                             </div>
                                             </td>
                                        </tr>
                                        <?php
                                   }
                              }
                              ?>
                         </tbody>
                    </table>
                    <div class="align-content-center">
                    <button class="btn btn-primary mb-2" formaction="<?php echo FRONT_ROOT ?>Movies/Delete" type="submit">Delete</button>
                    </div>
               </form>
          
          </div>
     </div>
</div>
</section>