<?php
include('navbaradmin.php');
?>
<main class="d-flex  justify-content-center ">
 <div class="content">
    <header class="text-center">
 <h2 class="fuente4 text-center">Show Cinemas</h2>
</header>
<div class="login-form bg-dark-alpha p-5 bg-light">
<section>
    <br>
    <div class="form-group">
<form action="<?php echo FRONT_ROOT ?>Cinema/ShowCinemas" method="POST">
    <div class="form-group align-items-center">
        <h2 class="fuente5 text-center">CINEMAS</h2>
        <br>
        <button type="submit" class="btn btn-primary offset-4"  >Show Cinemas</button>
    </div>
</form>
</div>
<br>
<br>
<form action="<?php echo FRONT_ROOT ?>Cinema/ShowCinema" method="POST">
    <div class="form-group">
       
        <input type="text" name="wantedCinema" placeholder="Search Cinema" required class="form-control">
        <br>
        <button type="submit" class="btn btn-primary offset-4">Search Cinema</button>
  </div>
</form>

<form action="<?php echo FRONT_ROOT ?>Cinema/DeleteCinema" method="POST">
    <div class="form-group">
        <br>
        <input type="text" name="deleteCinema" class="form-control" placeholder="Enter Movie name to be deleted">
        <br>
        <button type="submit" class="btn btn-primary offset-4 " required >Delete Cinema</button>
    </div>
</form>

<form action="<?php echo FRONT_ROOT ?>Cinema/ModifyCinema" method="POST">
    <div class="form-group">
        <br>
        <input type="text" name="id" placeholder="Enter Id to be modify" required class="form-control">
        <br>
        <input type="text" name="name" class="form-control" required placeholder="Enter movie name to be modify">
        <br>
        <input type="text" name="adress" placeholder="Enter Cinema Adress" required class="form-control">
        <br>
        <input type="text" name="openingTime" placeholder="Enter Opening Time" required class="form-control">
        <br>
        <input type="text" name="closingTime"placeholder="Enter Closing Time" required class="form-control">
        <br>
        <input type="text" name="ticketValue" placeholder="Enter Ticket Value" required class="form-control">
           <br>
        <button type="submit" class="btn btn-primary offset-4  ">Modify Cinema</button>
    </div>
</form>
</section>
</div>
</div>
</main>

