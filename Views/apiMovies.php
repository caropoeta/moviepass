<section>
<?php include('navbaradmin.php'); ?>
</section>



     <section id="listado" class="mb-5">
          <div class="container-fluid">
               <h2 class="fuente4  text-center">Movie List From Api</h2>
               <div class="col-auto">
                    <form method="POST">
                         <div class="align-items-center">
                         <button class="btn btn-primary mb-2 " formaction="<?php echo FRONT_ROOT ?>Api/List/" type="page" name="id" value="<?php echo $currPage - 1 ?>">Back Page</button>
                         <button class="btn btn-primary mb-2  " formaction="<?php echo FRONT_ROOT ?>Api/List/" type="page" name="id" value="<?php echo $currPage + 1 ?>">Next Page</button>
                    </div>
                    </form>
               </div>
               <div class=col-auto>
                    <div class="">
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

                                   use Models\Movie as Movie;
                                   use Models\UserModel as UserModel;
                                   
                                   foreach ($movies as $movie) {
                                        if ($movie instanceof Movie) { ?>
                                             <tr>
                                                  <td><?php echo $movie->getTitle(); ?></td>
                                                  <td><?php echo $movie->getDescription(); ?></td>
                                                  <td><?php
                                                  foreach ($movie->getGenres() as $value) {
                                                       echo $value . '<br>';
                                                  }
                                                  ?></td>
                                                  <td><?php echo '<img src="https://image.tmdb.org/t/p/w500' . $movie->getPoster() . '" width="250" height="357">' ?></td>
                                                  <td>
                                                       <div class="col-auto">
                                                            <form method="POST">
                                                            
                                                            <button class="btn btn-primary mb-2" formaction="<?php echo FRONT_ROOT ?>Movies/Add" type="submit" name="id" value="<?php echo $movie->getId(); ?>">Add</button>
                                                       
                                                            </form>
                                                       </div>
                                                  </td>
                                             </tr>
                                   <?php
                                        }
                                   }
                                   ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </section>
