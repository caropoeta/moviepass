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
    
    <input id="price" type="hidden" value="<?php echo $data['price'] ?>">
    <input id="discountMinTickets" type="hidden" value="<?php echo $discountMinTickets ?>">
    <input id="discountPercentaje" type="hidden" value="<?php echo $discountPercentaje ?>">

    <label style="color:#fff">Total price: $</label><input type="number" readonly id="priceHolder"></input>
    <br>
    <form action="<?php echo FRONT_ROOT ?>Ticket/SelectCreditCard" method="POST">
        <label style="color:#fff">Tickets to buy: </label><input id="numberOfTickets" type="number" min="1" max="<?php echo $maxTickets ?>" value="1" name="TicketsToBuy" onchange="getPrice()">
        <br>
        <button type="submit" class="botons-chico"name="funid" value="<?php echo $data['id'] ?>">Select credit card</button>
    </form>

    <script>
        function getPrice() {
            var price = Number(document.getElementById('price').value);
            var numberOfTickets = Number(document.getElementById('numberOfTickets').value);
            var discountMinTickets = Number(document.getElementById('discountMinTickets').value);
            var discountPercentaje = Number(document.getElementById('discountPercentaje').value);

            if (numberOfTickets >= discountMinTickets)
                price *= 1 - discountPercentaje;

            document.getElementById('priceHolder').value = price * numberOfTickets;
        }

        getPrice();
    </script>
</div>