<?php

use Models\Functions;

include('navbaradmin.php');

?>
<h2 class="fuente text-center"> Functions Admin</h2>
<br>

<div class="p-2 text-center">
    <table class="table">
        <thead>
            <tr>
                <th>Starting time</th>
                <th>Finish time</th>
                <th>Movie</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($functions != false) foreach ($functions as $function) {
                if ($function != null && $function instanceof Functions) {
            ?>
                    <tr>
                        <td><?php echo $function->getTime() ?></td>
                        <td><?php echo $function->getfinishTime() ?></td>
                        <td><?php echo $function->getMovie()->getTitle() ?></td>
                        <td>
                            <form action=<?php echo FRONT_ROOT . 'Functions/Delete' ?> method="POST">
                                <input type="hidden" name="id" value=<?php echo $function->getidFunction() ?>>
                                <button type=submit>Delete </button>
                            </form>
                        </td>
                        <td>
                            <div class="col-auto">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#update<?php echo $function->getidFunction() ?>">
                                    Update
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade bd-example-modal-lg" id="update<?php echo $function->getidFunction() ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Update function</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="time" name="Starting time" value="<?php echo $function->getTime() ?>" placeholder="Enter Closing Time" required class="form-control">
                                        <br>
                                        <input type="hidden" name="roomid" value="<?php echo $roomId ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button formaction="<?php echo FRONT_ROOT ?>Functions/SelectMovieUpdate" class="btn btn-primary offset-6 btn-md active" type="submit" name="id" value="<?php echo $roomId ?>">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<div class="col-auto">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#add">
        Add function
    </button>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add function</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="time" name="Starting time" placeholder="Enter Closing Time" required class="form-control">
                    <br>
                    <input type="hidden" name="roomid" value="<?php echo $roomId ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button formaction="<?php echo FRONT_ROOT ?>Functions/SelectMovieAdd" class="btn btn-primary offset-6 btn-md active" type="submit" name="id" value="<?php echo $roomId ?>">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>