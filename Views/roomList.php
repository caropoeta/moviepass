<?php

include('navbaradmin.php');

?>
<div class="wrapper row4">
  <main class="hoc container clear"> 
    
    <div class="content"> 
    <form method = "POST" action = <?php echo FRONT_ROOT."Room/ShowAddView" ?>>
        <button id="buttons" class="btn btn-danger float-right" type="submit" name = "idCinema" value = <?php echo $idCinema?> >+ Sala</button>
      </form>
      <div class="scrollable">
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Capacity</th>
              <th>Price</th>
              <th>Update</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if($lista!=false)foreach($lista as $room)
              {
                ?>
                  <tr>
                    <td><?php echo $room->getName() ?></td>
                    <td ><?php echo $room->getCapacity() ?></td>
                    <td ><?php echo $room->getPrice() ?></td>
                      <form action=<?php echo FRONT_ROOT.'Room/ShowUpdateRoom'?> method = "POST">
                        <input type="hidden" name = "id" value=<?php echo $room->getId() ?>>
                        <button type=submit>Update </button>
                      </form>
                    </td>
                    <td class="border">
                      <form action=<?php echo FRONT_ROOT.'Room/Remove'?> method = "POST">
                        <input  name = "id" value=<?php echo $room->getId() ?>>
                        <input  name = "cinemaId" value=<?php echo $room->getCinema()->getId()?>>
                        <button type=submit> Delete </button>
                      </form>
                    </td>
                  </tr>
                <?php
              }
            ?>                          
          </tbody>
        </table> 
      </div>
    </div>
    <div class="clear"></div>
  </main>
</div>
