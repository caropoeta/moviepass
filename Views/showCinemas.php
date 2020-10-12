<?php

include('navbaradmin.php');

//Muestro lo encontrado para probar, borrar cuando este la vista hecha.
foreach ($cinemaList as $cinema) {
    echo "Name:" . $cinema->getName() . '<br>';
    echo "Adress" . $cinema->getAdress() . '<br>';
    echo "OpeningTime" . $cinema->getOpeningTime() . '<br>';
    echo "ClosingTime" . $cinema->getClosingTime() . '<br>';
    echo "ticketValue" . $cinema->getTicketValue() . '<br>';
    echo "Id" . $cinema->getId() . '<br>';
    echo "----------------------" . '<br>';
}
