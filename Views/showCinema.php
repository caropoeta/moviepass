<?php
include('navbaradmin.php');

if (empty($cinemaFound)) {

    echo "Cinema " . $cinemaSearched . " don't found";
} else {
    //Muestro lo encontrado para probar, borrar cuando este la vista hecha.
    echo "Name:" . $cinemaFound->getName() . '<br>';
    echo "Adress" . $cinemaFound->getAdress() . '<br>';
    echo "OpeningTime" . $cinemaFound->getOpeningTime() . '<br>';
    echo "ClosingTime" . $cinemaFound->getClosingTime() . '<br>';
    echo "ticketValue" . $cinemaFound->getTicketValue() . '<br>';
    echo "Id" . $cinemaFound->getId() . '<br>';
}
