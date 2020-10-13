<?php

include('navbaradmin.php');

?>
<h2 class="fuente text-center"> Cinemas Admin</h2>
<br>
<table class="table">
	<thead>
	<tr>
		<th>Name</th>
		<th>Adress</th>
		<th>Opening Time</th>
		<th>Closing Time</th>
		<th>Ticket Value</th>
		<th>Id</th>
	</tr>
</thead>
<tbody class="table-hover">

<?php
foreach ($cinemaList as $cinema) {
?>
<tr>
   <td><?php echo $cinema->getName()?></td>
   <td><?php echo $cinema->getAdress()?><td>
   <td><?php echo $cinema->getOpeningTime()?></td>
   <td><?php echo $cinema->getClosingTime()?></td>
   <td><?php echo $cinema->getTicketValue()?></td>
   <td><?php echo $cinema->getId()?></td>
       
                  </tr>
                <?php
              }
            ?>                          
          </tbody>
        </table>

     