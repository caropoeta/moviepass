<?php

include('navbaradmin.php');

?>
<h2 class="fuente text-center"> Cinemas Admin</h2>
<br>
<table class="table">
	<thead>
   <tr>
    <th>Id</th>
    <th>Name</th>
    <th>Adress</th>
    <th>Opening Time</th>
    <th>Closing Time</th>
    <th>Ticket Value</th>
  </tr>
</thead>
<tbody class="table-hover">

  <?php
  foreach ($cinemaList as $cinema) {
    ?>
    <tr>
     <td><?php echo $cinema->getId()?></td>
     <td><?php echo $cinema->getName()?></td>
     <td><?php echo $cinema->getAdress()?></td>
     <td><?php echo $cinema->getOpeningTime(). 'hs<br>';?></td>
     <td><?php echo $cinema->getClosingTime(). 'hs<br>';?></td>
     <td><?php echo "$" . $cinema->getTicketValue();?></td>
   </tr>
   <?php
 }
 ?>                          
</tbody>
</table>