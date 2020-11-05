<main class="d-flex  justify-content-center ">
   <div class="content">
    <header class="text-center">
        <h2 class="title-secondary">Cinema to modify</h2>
    </header>
    <div class="login-form">
        <section>
            <br>
            <div class="form-group">

                <form action="<?php echo FRONT_ROOT ?>Cinema/UpdateCinema" method="POST">
                    
                        <br>
                        <label>ID:</label>
                        <input type="text" name="id"  value="<?php echo $cinemaFound->getidCinema() ?>"  required class="form-group"readonly="readonly">
                        <br>
                        <label>Name:</label>
                        <input type="text" name="name" value="<?php echo $cinemaFound->getnameCinema() ?>" required class="form-group">
                        <br>
                        <label>Address:</label>
                        <input type="text" name="adress" value="<?php echo $cinemaFound->getaddress() ?>" required class="form-group">
                        <br>
                        <label>Opening Time:</label>
                        <input type="text" name="openingTime" value="<?php echo $cinemaFound->getopeningTime() ?>"  required class="form-group">
                        <br>
                        <label>Closing Time:</label>
                        <input type="text" name="closingTime" value="<?php echo $cinemaFound->getclosingTime()?>" required class="form-group">
                        <br>
                        <label>Ticket Value:</label>
                        <input type="text" name="ticketValue" value="<?php echo $cinemaFound->getticketValue() ?>" required class="form-group">
                        <br>
                        <label>Capacity:</label>
                        <input type="text" name="capacity" value="<?php echo $cinemaFound->getcapacity() ?>" required class="form-group">
                        <br>
                        <button type="submit" class="botons">Modify Cinema</button>  
                    
                </form>

                <form method="POST">
                  <div class="fuente4 text-center">
                      <button formaction="<?php echo FRONT_ROOT ?>Cinema" class="botons" type="submit">Back</button>
                  </div>
              </form>
          </div>
      </section>
  </div>
</div>
</main>

