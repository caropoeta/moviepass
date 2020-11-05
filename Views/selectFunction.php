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
                <th>Cinema's name</th>
                <th>Cinema's address</th>
                <th>Movie name</th>
                <th>Function day</th>
                <th>Starting time</th>
                <th>Finish time</th>
                <th>Room's name</th>
                <th>Price</th>
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
                            <button class="botons" type="submit" name="funid" value="<?php echo $dat['id'] ?>">Select function</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </form>
        </tbody>
    </table>
</div>