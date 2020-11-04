<?php

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
                <th>Number of tickets</th>
                <th>Total price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $data['cinemaName'] ?></td>
                <td><?php echo $data['address'] ?></td>
                <td><?php echo $movTitle ?></td>
                <td><?php echo $data['day'] ?></td>
                <td><?php echo $data['time'] ?></td>
                <td><?php echo $data['finishTime'] ?></td>
                <td><?php echo $data['roomName'] ?></td>
                <td><?php echo '$' . $data['price'] ?></td>
                <td><?php echo $numberOfTickets ?></td>
                <td><?php echo '$' . $price ?></td>
            </tr>
        </tbody>
    </table>
</div>