<?php

use Models\Functions;

include('navbaradmin.php');
?>
<div>
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#ccAdd">
        Set filters
    </button>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="ccAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add credit card</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="movid" value="<?php echo $idMov ?>">

                        <label for="strt">Start of period:</label>
                        <input id="strt" type="date" name="strt" value="<?php echo $strtPeriod ?>" required>
                        <br>
                        <label for="end">End of period:</label>
                        <input id="end" type="date" name="end" value="<?php echo $endPeriod ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button formaction="<?php echo FRONT_ROOT ?>Movies/GetMovieStatisics" class="btn btn-primary offset-6 btn-md active" type="submit">Set filters</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <th> Title </th>
            <th> Total capacity </th>
            <th> Total money recolected </th>
            <th> Total asists </th>
        </thead>
        <tbody>
            <?php if ($movStatics != null) { ?>
                <tr>
                    <td><?php echo $movStatics['title'] ?></td>
                    <td><?php echo $movStatics['totCapacity'] ?></td>
                    <td><?php echo $movStatics['totMoneyRecolected'] ?></td>
                    <td><?php echo $movStatics['totAsists'] ?></td>
                <tr>
                <?php } else {} ?>
        </tbody>
    </table>
    <form action="<?php echo FRONT_ROOT ?>Movies/List" method="POST">
        <button class="btn btn-primary offset-6 btn-md active" type="submit">Home</button>
    </form>
</div>