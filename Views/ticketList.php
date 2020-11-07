<?php

use DAO\TicketDAO;
use Models\CreditCard;
use Models\Ticket;

if ($currRole == ADMIN_ROLE_NAME) include('navbaradmin.php');

if ($currRole == CLIENT_ROLE_NAME) include('navbarclient.php');
?>

<div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="stfilters" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="<?php echo FRONT_ROOT ?>Ticket/List" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Set filters</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="movieTitle">Movie Title:</label>
                        <input type="text" id="movieTitle" name="movieTitle" value="<?php echo $movieName ?>">
                        <br>
                        <label for="date">Date:</label>
                        <input id="date" type="date" name="date" value="<?php echo $date ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button formaction="<?php echo FRONT_ROOT ?>Ticket/List" class="btn btn-primary offset-6 btn-md active" type="submit">Set</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#stfilters">
        Set filters
    </button>

    <hr>
    <table class="table bg-light">
        <thead class="bg-dark text-white">
            <th>Title</th>
            <th>Seat Number</th>
            <th>Room name</th>
            <th>Date</th>
            <th>QR</th>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket) {
                if ($ticket instanceof Ticket) { ?>
                    <tr>
                        <td><?php echo $ticket->getMovieTitle() ?></td>
                        <td><?php echo $ticket->getSeat() ?></td>
                        <td><?php echo $ticket->getFunctionName() ?></td>
                        <td><?php echo $ticket->getDate() ?></td>
                        <td><img src="<?php echo $ticket->getQr() ?>" width="100" height="100"></td>

                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>