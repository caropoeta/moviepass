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
     <div class="container-movies">
        
          <form method="POST">
               <div class="form-group">
                    <small style="color:black"class="offset-5">
                         <br>
                         *Search either by name or date and genres.
                    </small>
                         <input  class="form-group" type="text" name="name" placeholder="Enter movie name" value="<?php echo $name ?>">
                    
               </div>
               <br><br><br>
               <div class="form-group" style="margin:auto">
                    <small style="color:black" class="text-muted">
                         *Search by year.
                    </small>
                    <br>
                    <input min="1582" max="9999"  type="number" class="form-group" name="year" placeholder="Enter movie year of release" value=<?php echo $year ?>>
                    <br>
                    <button class="botons"  formaction="<?php echo FRONT_ROOT ?>Api/List/" name="page" value="1" type="submit">Search</button>

               </div>
               <br><br>
               <div class="form-group">
                    <small style="color:black" class="offset-5">
                    <br>
                         *Search with genres.
                    </small>
                    <br>
                         
                         <input type='hidden' name='genre-with' value="[]" />
                        
                         <?php foreach ($genres as $value) {
                              if ($value instanceof Genre) {
                         ?>
                                   
                                   <input <?php if (GenreDAO::searchInGeneres($value->getId(), $genreW)) echo 'checked' ?> type="checkbox" class="form-check-input" id="gnr<?php echo $value->getId() ?>" name="genre-with[]" value="<?php echo $value->getId() ?>">
                                   <label class="form-check-label" for="gnr<?php echo $value->getId() ?>"> <?php echo $value->getDescription() ?></label><br>
                         <?php
                              }
                         } ?>
                         
               </div>
               <div class="form-group">
                    <br>
                    <small style="color:black" class="offset-5">
                         *Search without genres.
                    </small>
                    <br>
                         <input type='hidden' name='genre-without' value="[]" />
                         <?php foreach ($genres as $value) {
                              if ($value instanceof Genre) {
                         ?>
                                   <input <?php if (GenreDAO::searchInGeneres($value->getId(), $genreWO)) echo 'checked' ?> type="checkbox" class="form-check-input" id="gnr<?php echo $value->getId() ?>" name="genre-without[]" value="<?php echo $value->getId() ?>">
                                   <label class="form-check-label" for="gnr<?php echo $value->getId() ?>"> <?php echo $value->getDescription() ?></label><br>
                         <?php
                              }
                         } ?>
               </div>
     </div>
               
          </form>
          <br>
          <hr>
                   <form>
          <div class="p-2">
               <button class="botons-chico" id="izq"formaction="<?php echo FRONT_ROOT ?>Api/List/" type="submit" name="page" value="<?php echo $currPage - 1 ?>">Back Page</button>
          </div>
          <div class="p-2">
               <button class="botons-chico"  id="der" formaction="<?php echo FRONT_ROOT ?>Api/List/" type="submit" name="page" value="<?php echo $currPage + 1 ?>">Next Page</button>
          </div>
          </form>
          
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
                                                  echo '<img src="https://image.tmdb.org/t/p/w500' . $movie->getPoster() . '" width="100" height="142">';
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
                    
                    <button class="botons-chico" id="addmovie" style="float:right" formaction="<?php echo FRONT_ROOT ?>Movies/Delete" type="submit">Delete</button>
                    
               </form>
          
          </div>
     </div>
</div>
</section>