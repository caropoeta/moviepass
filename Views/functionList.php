<?php

include('navbaradmin.php');

?>
<h2 class="fuente text-center"> Function Admin</h2>
<br>

<form method="POST">
  <div class="p-2 text-center">
    <table class="table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Start Time</th>
          <th>Assistance</th>
          <th>Day of Week<th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($lista != false) foreach ($lista as $filmFunction) {
          ?>
          <tr>
            <td><?php echo $filmFunction->getIdMovieFunction() ?></td>
            <td><?php echo $filmFunction->getStartFunction() ?></td>
            <td><?php echo $filmFunction->getAssistance() ?></td>
            <td><?php echo $filmFunction->getDaysOfWeek() ?></td>


            <td>
              <form action=<?php echo FRONT_ROOT . 'Function/ShowUpdateFunction' ?> method="POST">
                <input type="hidden" name="id" value=<?php echo $filmFunction->getIdMovieFunction() ?>>
                <button type=submit>Update </button>
              </form>
            </td>
            <td>
              <form action=<?php echo FRONT_ROOT . 'Function/Remove' ?> method="POST">
                <input type="hidden" name="id" value=<?php echo $filmFunction->getIdMovieFunction() ?>>
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
</form>

<form method="POST" action=<?php echo FRONT_ROOT . "FilmFunction/AddFunction"; ?>>
  <div align=center>
    <h2>Add Function </h2>
    <div class="form-register">
      <div class="form-register-ul">
<table> <td>

        <input type="checkbox" id="monday" name ="dayOfWeek[]" value="monday">

        <label for="monday">   Monday</label><br>

        <input type="checkbox" id="Tuesday" name="dayOfWeek[]" value="tuesday">

        <label for="tuesday"> Tuesday</label><br>

        <input type="checkbox" id="Wednesday" name="dayOfWeek[]" value="wednesday">

        <label for="wednesday"> Wednesday</label><br> 

        <input type="checkbox" id="Thursday" name="dayOfWeek[]" value="thursday">

        <label for="thursday">  Thursday</label><br>
      </td>
        <td>

        <input type="checkbox" id="Friday" name="dayOfWeek[]" value="friday">

        <label for="friday">   Friday</label><br>

        <input type="checkbox" id="Saturday" name="dayOfWeek[]" value="saturday">

        <label for="saturday"> Saturday</label><br>

        <input type="checkbox" id="Sunday" name="dayOfWeek[]" value="sunday">

        <label for="sunday">   Sunday</label><br>
        </td>
        </table>

        <br>
        <input style="width:50%" type="time" name="startFunction" placeholder="Date" required class="form-control">

        <input style="width:50%" type="number" name="assistance" placeholder="Assistance" required class="form-control" min="50" max="1000">
        <br>
        <button type="submit" name="idRoom" value=<?php echo $roomId ?> class="btn btn-primary">Add</button>
        <br>
      </div>
    </div>
  </div>
</form>

<form method="POST">
  <div class="fuente4 text-center">
    <button formaction="<?php echo FRONT_ROOT ?>Room/List" class="btn btn-secondary" type="submit">Back</button>
  </div>
</form>