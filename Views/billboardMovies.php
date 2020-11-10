<section>
    <?php

    use Models\Genre;
    use Models\Movie as Movie;

    if ($currRole == GUEST_ROLE_NAME) { ?>
        <form action="<?php echo FRONT_ROOT ?>Home" method="POST">
            <button type="submit"></button>
        </form>
    <?php }

    if ($currRole == ADMIN_ROLE_NAME) include('navbaradmin.php');

    if ($currRole == CLIENT_ROLE_NAME) include('navbarclient.php');
    ?>
</section>

<section id="listado" class="mb-5">
    <div class="container-fluid">
        <h2 class="title-secondary">Billboard</h2>
        <form method="POST">
            <div class="fuente4 text-center">
                <button formaction="<?php echo FRONT_ROOT ?>home/MainPage" class="btn btn-secondary" type="submit">Back</button>
            </div>
        </form>
        <br>
        <div>
            <div class="form-group-movies">
                <h3>Choose an option to filter</h3>
                <br>
                <div class="container-movies">
                    <small style="color:black;">
                        *Search either by name or date and genres.
                    </small>
                    <form method="POST">
                        <div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Enter movie name" value="<?php echo $name ?>">
                            </div>

                            <div class="form-check">
                                <small style="color:black;">
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
                                <small style="color:black;">
                                    *Search wiithout genres.
                                </small>
                                <br>
                                <input type='hidden' name='genre-without' value="[]" />
                                <?php foreach ($genres as $value) {
                                    if ($value instanceof Genre) {
                                ?>
                                        <input <?php if (in_array($value->getId(), $genreWO)) echo 'checked' ?> type="checkbox" class="form-check-input" id="gnrO<?php echo $value->getId() ?>" name="genre-without[]" value="<?php echo $value->getId() ?>">
                                        <label class="form-check-label" for="gnrO<?php echo $value->getId() ?>"> <?php echo $value->getDescription() ?></label><br>
                                <?php
                                    }
                                } ?>
                            </div>
                            <br>
                            <div class="form-group">
                                <small style="color:black">
                                    *Search by year.
                                </small style="color:black">
                                <input type="number" min="0000" max="9999" class="form-control" name="year" placeholder="Enter movie year of release" value=<?php echo $year ?> required>
                            </div>

                            <button class="botons" formaction="<?php echo FRONT_ROOT ?>Billboard/List/" name="page" value="1" type="submit">Search</button>
                        </div>
                </div>
            </div>
            <hr>
            <div class="align-items-center">
                <button class="botons-chico" style="margin-left: 25%" formaction="<?php echo FRONT_ROOT ?>Billboard/List/" type="submit" name="page" value="<?php echo $currPage - 1 ?>">Back Page</button>
                <button class="botons-chico" formaction="<?php echo FRONT_ROOT ?>Billboard/List/" type="submit" name="page" value="<?php echo $currPage + 1 ?>">Next Page</button>
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
                        <?php if ($currRole == CLIENT_ROLE_NAME || $currRole == ADMIN_ROLE_NAME) { ?>
                            <th></th>
                        <?php
                        }
                        ?>
                    </thead>
                    <tbody>
                        <form action="<?php echo FRONT_ROOT ?>Ticket/SelectFunction/" method="POST">
                            <?php foreach ($movies as $movie) {
                                if ($movie instanceof Movie) { ?>
                                    <tr style="font-size:large">
                                        <td><?php echo $movie->getTitle(); ?></td>
                                        <td><?php echo $movie->getDescription(); ?></td>
                                        <td><?php
                                            foreach ($movie->getGenres() as $value) {
                                                if ($value instanceof Genre)
                                                    echo $value->getDescription() . '<br>';
                                            }
                                            ?></td>
                                        <td>
                                            <?php if ($movie->getPoster() != null) {
                                                echo '<img src="https://image.tmdb.org/t/p/w500' . $movie->getPoster() . '" width="100" height="147">';
                                            }
                                            ?>
                                        </td>
                                        <?php if ($currRole == CLIENT_ROLE_NAME || $currRole == ADMIN_ROLE_NAME && $movHasFreeSeats[$movie->getId()]) { ?>
                                            <td>
                                                <button class="botons" name="movieId" value="<?php echo $movie->getId(); ?>" type="submit">Buy ticket</button>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>