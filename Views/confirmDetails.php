<?php

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
                <th>Movie's name</th>
                <th>Function day</th>
                <th>Starting time</th>
                <th>Finish time</th>
                <th>Room's name</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $data['cinemaName'] ?></td>
                <td><?php echo $data['address'] ?></td>
                <td><?php echo $movieName ?></td>
                <td><?php echo $data['day'] ?></td>
                <td><?php echo $data['time'] ?></td>
                <td><?php echo $data['finishTime'] ?></td>
                <td><?php echo $data['roomName'] ?></td>
                <td><?php echo '$' . $data['price'] ?></td>
            </tr>
        </tbody>
    </table>

    <script>
        function getPrice() {
            var n1 = Number(document.getElementById('price').value);
            var n2 = Number(document.getElementById('numberOfTickets').value);
            document.getElementById('priceHolder').value = n1 * n2;
        }
    </script>
    <div class="login-form">
    <input id="price" type="hidden" value="<?php echo $data['price'] ?>">
    <label>Total price: $</label><input type="number" readonly id="priceHolder" value="<?php echo $data['price'] ?>"></input>
    <br>
    <form action="<?php echo FRONT_ROOT ?>Ticket/Buy" method="POST">
        <label>Tickets to buy: </label><input id="numberOfTickets" type="number" min="1" max="<?php echo $maxTickets ?>" value="1" name="TicketsToBuy" onchange="getPrice()">
        <br>
        <button class="botons-chico"type="submit" name="funid" value="<?php echo $data['id'] ?>">Buy</button>
    </form>
    </div>
</div>