<?php

use Models\Ticket;

$htmlMsg = "<h1>" . "Hi!, this is a copy of the tickets that you bought at " . $hostname . ".</h1>";
$htmlMsg .= "<table>";
$htmlMsg .= "<thead>";
$htmlMsg .= "<th>Title</th>";
$htmlMsg .= "<th>Seat number</th>";
$htmlMsg .= "<th>Cinema</th>";
$htmlMsg .= "<th>Room</th>";
$htmlMsg .= "<th>Date</th>";
$htmlMsg .= "<th>QR</th>";
$htmlMsg .= "</thead>";
$htmlMsg .= "<tbody>";

foreach ($tickets as $value) {
    if ($value instanceof Ticket) {
        $htmlMsg .= "<tr>";
        $htmlMsg .= "<td>" . $value->getMovieTitle() . "</td>";
        $htmlMsg .= "<td>" . $value->getSeat() . "</td>";
        $htmlMsg .= "<td>" . $value->getCinemaName() . "</td>";
        $htmlMsg .= "<td>" . $value->getFunctionName() . "</td>";
        $htmlMsg .= "<td>" . $value->getDate() . ' ' . $value->getHour() . "</td>";
        $htmlMsg .= "<td><img src='" . $value->getQr() . "' width='150' height='150'> </td>";
        $htmlMsg .= "</tr>";
    }
}

$htmlMsg .= "</tbody>";
$htmlMsg .= "</table>";

return $htmlMsg;
