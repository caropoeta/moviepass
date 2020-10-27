<?php
include('navbaradmin.php');
?>
<main class="d-flex  justify-content-center ">
 <div class="content">
    <header class="text-center">
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

            <h2 class="fuente5 text-center"> Add cinema</h2>
            <form action="<?php echo FRONT_ROOT ?>Cinema/AddCinema" method="POST">
                <div class="form-group">
                    <br>
                    <input type="text" name="name" class="form-control" required placeholder="Enter Cinema Name">
                    <br>
                    <input type="text" name="adress" placeholder="Enter Cinema Adress" required class="form-control">
                    <br>
                    <input type="time" name="openingTime" placeholder="Enter Opening Time" required class="form-control">
                    <br>
                    <input type="time" name="closingTime" placeholder="Enter Closing Time" required class="form-control">
                    <br>
                    <input type="number" name="ticketValue" placeholder="Enter Ticket Value" required class="form-control">
                    <br>
                    <input type="number" name="capacity" placeholder="Enter Capacity Value" required class="form-control">
                    <br>
                    <button type="submit" class="btn btn-primary offset-4  ">Add Cinema</button>
                </div>
            </form>
        </section>
    </div>
</div>
</main>

