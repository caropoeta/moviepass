<?php

include('navbaradmin.php');

?>
<h2 class="fuente text-center"> Cinemas Admin</h2>
<br>

<form method="POST">
      <div class="p-2">
          <button formaction="<?php echo FRONT_ROOT ?>Cinema" class="btn btn-secondary" type="submit">Back</button>
        </div>
</form>
  <table class="table">
   <thead>


     <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Adress</th>
      <th>Opening Time</th>
      <th>Closing Time</th>
      <th>Ticket Value</th>
      <th>Capacity</th>

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
       <td><?php echo $cinema->getCapacity();?></td>
       <th>
       <li class="nav-item">
        <form action="<?php echo FRONT_ROOT ?>Cinema/ModifyCinema" method="POST">
          <div class="p-2">
            <button class="btn btn-secondary" type="submit" name="modifyId" value="<?php echo $cinema->getId(); ?>">Modify</button>
          </div>
        </li>
      </form>
    </li>
  </th>
     </tr>
     <?php
   }
   ?>              
 </tbody>
</table>

