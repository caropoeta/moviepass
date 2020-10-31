<main class="d-flex  justify-content-center ">
   <div class="content">
    <header class="text-center">
        <h2 class="title-secondary">Cinema to modify</h2>
    </header>
    <div class="login-form bg-dark-alpha p-5 bg-light">
        <section>
            <br>
            <div class="form-group">

                <form action="<?php echo FRONT_ROOT ?>Cinema/UpdateCinema" method="POST">
                    <div class="form-group">
                        <br>
                        <input type="text" name="id"  value="<?php echo $cinemaFound->getidCinema() ?>"  required class="form-control"readonly="readonly">
                        <br>
                        <input type="text" name="name" value="<?php echo $cinemaFound->getnameCinema() ?>" required class="form-control">
                        <br>
                        <input type="text" name="adress" value="<?php echo $cinemaFound->getaddress() ?>" required class="form-control">
                        <br>
                        <input type="text" name="openingTime" value="<?php echo $cinemaFound->getopeningTime() ?>"  required class="form-control">
                        <br>
                        <input type="text" name="closingTime" value="<?php echo $cinemaFound->getclosingTime()?>" required class="form-control">
                        <br>
                        <input type="text" name="ticketValue" value="<?php echo $cinemaFound->getticketValue() ?>" required class="form-control">
                        <br>
                        <input type="text" name="capacity" value="<?php echo $cinemaFound->getcapacity() ?>" required class="form-control">
                        <br>
                        <button type="submit" class="btn btn-primary offset-4">Modify Cinema</button>  
                    </div>
                </form>

                <form method="POST">
                  <div class="fuente4 text-center">
                      <button formaction="<?php echo FRONT_ROOT ?>Cinema" class="btn btn-secondary" type="submit">Back</button>
                  </div>
              </form>
          </div>
      </section>
  </div>
</div>
</main>

