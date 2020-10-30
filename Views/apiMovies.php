<section>
     <?php
     include('navbaradmin.php');

     use DAO\GenreDAO;
     use Models\Genre;
     use Models\Movie as Movie;
     ?>
</section>



<section id="listado" class="mb-5">
     <div class="container-fluid">
          <h2 class="fuente4  text-center">Movie List From Api</h2>
          <br>
          <div class="col-auto">
               <small class="text-muted">
                    *Search either by name or date and genres.
               </small>

               <form method="POST">
                    <div>
                         <div class="form-group">
                              <input style="width:25%" type="text" class="form-control" name="name" placeholder="Enter movie name" value="<?php echo $name ?>">
                         </div>

                         <div class="form-check">
                              <small class="text-muted">
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
                         <br>
                         <div class="form-check">
                              <small class="text-muted">

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
                         <br>
                         <div class="form-group">
                              <small class="text-muted">
                                   *Search by year.
                              </small>
                              <input min="0000" max="9999" style="width:10%" type="number" class="form-control" name="year" placeholder="Enter movie year of release" value=<?php echo $year ?>>
                         </div>

                         <button class="btn btn-primary mb-2" formaction="<?php echo FRONT_ROOT ?>Api/List/" name="page" value="1" type="submit">Search</button>
                    </div>
                    <hr>
                    <div class="align-items-center">
                         <button class="btn btn-primary mb-2 " formaction="<?php echo FRONT_ROOT ?>Api/List/" type="submit" name="page" value="<?php echo $currPage - 1 ?>">Back Page</button>
                         <button class="btn btn-primary mb-2  " formaction="<?php echo FRONT_ROOT ?>Api/List/" type="submit" name="page" value="<?php echo $currPage + 1 ?>">Next Page</button>
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
                                                            echo '<img src="https://image.tmdb.org/t/p/w500' . $movie->getPoster() . '" width="250" height="357">';
                                                       } ?></td>
                                                  <td>
                                                       <div class="col-auto">
                                                            <?php if (!$currMov[$movie->getId()]) { ?>
                                                                 <input type="checkbox" class="form-check-input" id="mov<?php echo $movie->getId() ?>" name="mov[]" value="<?php echo $movie->getId() ?>">
                                                                 <label class="form-check-label" for="mov<?php echo $movie->getId() ?>">Add</label><br>
                                                            <?php } ?>
                                                       </div>
                                                  </td>
                                             </tr>
                                   <?php
                                        }
                                   }
                                   ?>
                              </tbody>
                         </table>

                         <button class="btn btn-primary mb-2" formaction="<?php echo FRONT_ROOT ?>Movies/Add" type="submit">Add</button>
                    </form>
               </div>
          </div>
     </div>
</section>