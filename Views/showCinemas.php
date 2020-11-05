<?php

use Models\PopupAlert;

include('navbaradmin.php');

?>
<br>
<br>
<br>
<h2 class="title-secondary"> Cinemas Admin</h2>
<br>
<br>
<br>

<form method="POST">
  <div>
    <button formaction="<?php echo FRONT_ROOT ?>Cinema" class="botons-chico" id="back-button" type="submit" name="action" value="register"> Back </button>
  </div>
  <div class="p-2 text-center" >
    <table class="table">
      <thead>
          <th>Id</th>
          <th>Name</th>
          <th>Address</th>
          <th>Opening Time</th>
          <th>Closing Time</th>
          <th>Ticket Value</th>
          <th>Capacity</th>
          <th>Room</th>
          <th>Modify</th>
          <th>Delete</th>
          <th>Statistics</th>

        
      </thead>
      <tbody class="table-hover">

        <?php
        if (is_array($cinemaList) || is_object($cinemaList)) {
          foreach ($cinemaList as $cinema) {
        ?>
            <tr>
              <td><?php echo $cinema->getidCinema() ?></td>
              <td><?php echo $cinema->getnameCinema() ?></td>
              <td><?php echo $cinema->getaddress() ?></td>
              <td><?php echo $cinema->getopeningTime() . 'hs<br>'; ?></td>
              <td><?php echo $cinema->getclosingTime() . 'hs<br>'; ?></td>
              <td><?php echo "$" . $cinema->getticketValue(); ?></td>
              <td><?php echo $cinema->getcapacity(); ?></td>

              <td >
                <form method="POST">

                  <button formaction="<?php echo FRONT_ROOT ?>Room/List" class="botons" type="submit" name="room"  value="<?php echo $cinema->getidCinema(); ?>">Rooms</button>
                  <br>
                </form>
              </td>
              <td >
                <form method="POST">
                  <button formaction="<?php echo FRONT_ROOT ?>Cinema/ModifyCinema" class="botons" type="submit"  name="modifyId" value="<?php echo $cinema->getidCinema(); ?>">Modify</button>
                  <br>
                </form>
              </td>
              <td >
                <button formaction="<?php echo FRONT_ROOT ?>Cinema/DeleteCinema" class="botons" type="submit" name="deleteId" value="<?php echo $cinema->getidCinema(); ?>">Delete</button>
              </td>
              <td >
              <button formaction="<?php echo FRONT_ROOT ?>Cinema/Statistics"
										class="botons" type="submit" name="cinemaId"
										value="<?php echo $cinema->getidCinema(); ?>">Statistics</button>
              </td>
              </div>
</form>
</td>
</tr>
<?php
          }
        }
?>
</tbody>
</table>
</div>