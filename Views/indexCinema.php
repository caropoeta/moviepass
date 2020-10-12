
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../Config/Autoload.php";
require "../Config/Config.php";


?>
<form action="../Process/Cinemas.php" method="POST">

    <div class="form-group">
        <label for="">CINEMAS</label>
        <button type="submit" class="button-primary" name="buttonShowCinemas">Show Cinemas</button>
    </div>

</form>

<form action="../Process/Cinemas.php" method="POST">

    <div class="form-group">
        <label for="">Search Cinema</label>
        <input type="text" name="wantedCinema">
        <button type="submit" class="button-primary" name="buttonShowCinema">Show Cinema</button>
    </div>

</form>

<form action="../Process/Cinemas.php" method="POST">

    <div class="form-group">
        <label for="">Enter movie name to be deleted</label>
        <input type="text" name="deleteCinema">
        <button type="submit" class="button-primary" name="buttonDeleteCinema">Clear Cinema</button>
    </div>


</form>

</form>

<form action="../Process/Cinemas.php" method="POST">

    <div class="form-group">
  
        <label for="">Enter Id to be modify</label>
        <input type="text" name="id">
        <label for="">Enter movie name to be modify</label>
        <input type="text" name="name">
        <input type="text" name="adress">
        <input type="text" name="openingTime">
        <input type="text" name="closingTime">
        <input type="text" name="ticketValue">

        <button type="submit" class="button-primary" name="buttonModifyCinema">Modify Cinema</button>
    </div>


</form>



