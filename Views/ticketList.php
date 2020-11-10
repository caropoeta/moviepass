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
                        <br>
                        <input type="radio" id="mta" name="orderby" value="mta" <?php if($orderby == 'mta') echo 'checked' ?>>
                        <label for="mta">Movie title asc</label><br>
                        <input type="radio" id="mtd" name="orderby" value="mtd" <?php if($orderby == 'mtd') echo 'checked' ?>>
                        <label for="mtd">Movie title dsc</label><br>
                        <input type="radio" id="cna" name="orderby" value="cna" <?php if($orderby == 'cna') echo 'checked' ?>>
                        <label for="cna">Cinema name asc</label><br>
                        <input type="radio" id="cnd" name="orderby" value="cnd" <?php if($orderby == 'cnd') echo 'checked' ?>>
                        <label for="cnd">Cinema name dsc</label><br>
                        <input type="radio" id="non" name="orderby" value="none" <?php if($orderby == 'none') echo 'checked' ?>>
                        <label for="non">None</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="botons-chico" data-dismiss="modal">Close</button>
                        <button formaction="<?php echo FRONT_ROOT ?>Ticket/List" class="botons-chico" type="submit">Set</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <button type="button" class="botons-chico" data-toggle="modal" data-target="#stfilters">
        Set filters
    </button>

    <hr>
    <table class="table bg-light">
        <thead class="bg-dark text-white">
            <th>Title</th>
            <th>Seat Number</th>
            <th>Cinema name</th>
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
                        <td><?php echo $ticket->getCinemaName() ?></td>
                        <td><?php echo $ticket->getFunctionName() ?></td>
                        <td><?php echo $ticket->getDate() . ' ' . $ticket->getHour() ?></td>
                        <td><img src="<?php echo $ticket->getQr() ?>" width="150" height="150"></td>

                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>