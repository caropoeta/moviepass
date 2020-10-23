<?php

include('navbaradmin.php');

?>
<h2 class="fuente text-center"> Cinemas Admin</h2>
<br>

<form method="POST">
  <div class="p-2 text-center">
    <button formaction="<?php echo FRONT_ROOT ?>Cinema" class="btn btn-secondary" type="submit" name="action" value="register"> Back </button>
  </div>

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
      if($cinema->getDelete()==false){
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
          <nav class="navbar navbar-expand-lg">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            </button>

            <ul class="navbar-nav ml-auto">
             <li class="nav-item">
              <form method="POST">
               <div class="p-2">
                <button formaction="<?php echo FRONT_ROOT ?>Cinema/ModifyCinema" class="btn btn-secondary" type="submit" name="modifyId" value="<?php echo $cinema->getId(); ?>">Modify</button>        
              </div>
            </li>

            <li class="nav-item">
             <div class="p-2">
              <button formaction="<?php echo FRONT_ROOT ?>Cinema/DeleteCinema" class="btn btn-secondary" type="submit" name="modifyId" value="<?php echo $cinema->getId(); ?>">Delete</button>        
            </div>
          </li>
        </form>
      </ul>

    </th>
  </tr>

  <?php
}
}
?>              
</tbody>
</table>

