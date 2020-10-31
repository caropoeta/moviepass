<?php

include('navbaradmin.php');

?>
<h2 class="title-secondary"> Rooms Admin</h2>
<br>

<div class="p-2 text-center">
  <table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Capacity</th>
        <th>Price</th>
        <th>Functions</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($lista != false) foreach ($lista as $room) {
      ?>
        <tr>
          <td><?php echo $room->getName() ?></td>
          <td><?php echo $room->getCapacity() ?></td>
          <td><?php echo $room->getPrice() ?></td>
          <td>
            <form action=<?php echo FRONT_ROOT . 'Functions/List' ?> method="POST">
              <input type="hidden" name="id" value=<?php echo $room->getId() ?>>
              <button type=submit>List functions </button>
            </form>
          </td>
          <td>
            <form action=<?php echo FRONT_ROOT . 'Room/ShowUpdateRoom' ?> method="POST">
              <input type="hidden" name="id" value=<?php echo $room->getId() ?>>
              <button type=submit>Update </button>
            </form>
          </td>
          <td>
            <form action=<?php echo FRONT_ROOT . 'Room/Remove' ?> method="POST">
              <input type="hidden" name="id" value=<?php echo $room->getId()?>>
              <input type="hidden" name="cinemaId" value=<?php echo $room->getCinema()->getidCinema() ?>>
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

<form method="POST" action=<?php echo FRONT_ROOT . "Room/Add"; ?>>
  <div align=center>
    <h2>Add Room </h2>
    <div class="form-register">
      <div class="form-register-ul">
        <input style="width:50%" type="text" name="name" placeholder="Room Name" required class="form-control">
        <br>
        <input style="width:50%" type="number" name="capacity" placeholder="Capacity" required class="form-control" min="50" max="1000">
        <br>
        <input style="width:50%" type="number" name="price" placeholder="Price" required class="form-control" min="50" max="1000">
        <br>
        <button type="submit" name="id" value="<?php echo $cinemaId ?>" class="btn btn-primary">Add</button>
        <br>
      </div>
    </div>
  </div>
</form>