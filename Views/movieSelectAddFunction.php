<?php
include('navbaradmin.php');

use DAO\MovieDAO;
use Models\Genre;
use Models\Movie;
?>

<div>
    <form method="POST">
        <div class="align-items-center">
            <input type="hidden" name="time" value="<?php echo $time ?>">
            <input type="hidden" name="day" value="<?php echo $date ?>">
            <input type="hidden" name="room" value="<?php echo $roomId ?>">
            <button class="btn btn-primary mb-2" formaction="<?php echo FRONT_ROOT ?>Functions/SelectMovieAdd" type="submit" name="page" value="<?php echo $page - 1 ?>">Back Page</button>
            <button class="btn btn-primary mb-2" formaction="<?php echo FRONT_ROOT ?>Functions/SelectMovieAdd" type="submit" name="page" value="<?php echo $page + 1 ?>">Next Page</button>
        </div>
    </form>

    <div class=col-auto>
        <div class="">
            <form action="<?php echo FRONT_ROOT ?>Functions/Add" method="POST">
                <input type="hidden" name="time" value="<?php echo $time ?>">
                <input type="hidden" name="day" value="<?php echo $date ?>">
                <input type="hidden" name="room" value="<?php echo $roomId ?>">

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
                                            <?php if (!MovieDAO::checkMovieDeletedById($movie->getId())) { ?>
                                                <button type="submit" class="botons" id="mov<?php echo $movie->getId() ?>" name="mov" value="<?php echo $movie->getId() ?>">Select</button>
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
            </form>
        </div>
    </div>
</div>
</div>