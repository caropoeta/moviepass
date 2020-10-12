<main class="d-flex align-items-center justify-content-center height-100">
     <section id="listado" class="mb-5">
          <div class="container-fluid">
               <h2 class="fuente4">Movie List From Api</h2>
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

                         use Models\UserModel as UserModel;

                         foreach ($movies as $movie) {
                              if ($movie instanceof UserModel) { ?>
                                   <tr>
                                        <td><?php echo $movie->getId(); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                             <div class="col-auto">
                                                  <form method="POST">
                                                       <!--
                                                            <button class="btn btn-primary mb-2" formaction="<?php echo FRONT_ROOT ?>Movies/Add" type="submit" name="id" value="<?php echo $movie->getId(); ?>">Add</button>
                                                       -->
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
     </section>
</main>