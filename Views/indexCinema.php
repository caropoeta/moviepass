<?php
include('navbaradmin.php');
?>

<br>

<form action="<?php echo FRONT_ROOT ?>Cinema/ShowCinemas" method="POST">
    <div class="form-group">
        <label for="">CINEMAS</label>
        <button type="submit" class="button-primary">Show Cinemas</button>
    </div>
</form>

<form action="<?php echo FRONT_ROOT ?>Cinema/ShowCinema" method="POST">
    <div class="form-group">
        <label for="">Search Cinema</label>
        <input type="text" name="wantedCinema">
        <button type="submit" class="button-primary">Show Cinema</button>
    </div>
</form>

<form action="<?php echo FRONT_ROOT ?>Cinema/DeleteCinema" method="POST">
    <div class="form-group">
        <label for="">Enter movie name to be deleted</label>
        <input type="text" name="deleteCinema">
        <button type="submit" class="button-primary">Clear Cinema</button>
    </div>
</form>

<form action="<?php echo FRONT_ROOT ?>Cinema/ModifyCinema" method="POST">
    <div class="form-group">
        <label for="">Enter Id to be modify</label>
        <input type="text" name="id">
        <label for="">Enter movie name to be modify</label>
        <input type="text" name="name">
        <input type="text" name="adress">
        <input type="text" name="openingTime">
        <input type="text" name="closingTime">
        <input type="text" name="ticketValue">

        <button type="submit" class="button-primary">Modify Cinema</button>
    </div>
</form>