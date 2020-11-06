<?php

use Models\Functions;

if ($currRole == ADMIN_ROLE_NAME) include('navbaradmin.php');
if ($currRole == CLIENT_ROLE_NAME) include('navbarclient.php');
?>

<br>
<div class="p-2 text-center">
    <table class="table">
        <thead>
            <tr>
                <th>Cinema name</th>
                <th>Cinema adress</th>
                <th>Movie name</th>
                <th>Function day</th>
                <th>Function starting time</th>
                <th>Function finish time</th>
                <th>Room name</th>
                <th>Room price</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <form action="<?php echo FRONT_ROOT ?>Ticket/ConfirmDetails" method="POST">
                <?php if ($data != false) foreach ($data as $dat) { ?>
                    <tr>
                        <td><?php echo $dat['cinemaName'] ?></td>
                        <td><?php echo $dat['address'] ?></td>
                        <td><?php echo $movieName ?></td>
                        <td><?php echo $dat['day'] ?></td>
                        <td><?php echo $dat['time'] ?></td>
                        <td><?php echo $dat['finishTime'] ?></td>
                        <td><?php echo $dat['roomName'] ?></td>
                        <td><?php echo '$' . $dat['price'] ?></td>
                        <td>
                            <button type="submit" name="funid" value="<?php echo $dat['id'] ?>">Select function</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </form>
        </tbody>
    </table>
</div>