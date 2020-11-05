<?php
include('navbaradmin.php');
?>
<br>
<br>
<br>
<br>
<h2 class="title-secondary">Search and Add a cinema</h2>

<main >
    <div class="content">
        <header class="text-center">
        </header>
        <div class="login-form " >
            <section>
                <br><h2>CINEMAS</h2>
                <div class="form-group" style="margin:auto">
                    <form action="<?php echo FRONT_ROOT ?>Cinema/ShowCinemas" method="POST">
                            
                            <br>
                            <button type="submit" class="botons">Show Cinemas</button>
                    </form>
                </div>
                <br>
                <br>
                <form action="<?php echo FRONT_ROOT ?>Cinema/ShowCinema" method="POST">
                    <div class="form-group" style="margin:auto">
                        <label> Insert Cinema name</label>
                        
                        <input type="text" name="wantedCinema" placeholder="Search Cinema" required class="form-group">
                        <br>
                        <button type="submit" class="botons">Search Cinema</button>
                    </div>
                </form>

                <div class="container">
                    <!-- Button trigger modal -->
                    <button type="button" class="botons" data-toggle="modal" data-target="#addcinema">
                        Add cinema
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade " id="addcinema" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add cinema</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <br>
                                        <input type="text" name="name" class="form-control" required placeholder="Enter cinema name">
                                        <br>
                                        <input type="text" name="adress" placeholder="Enter Cinema Adress" required class="form-control">
                                        <br>
                                        <input type="time" name="openingTime" placeholder="Enter Opening Time" required class="form-control">
                                        <br>
                                        <input type="time" name="closingTime" placeholder="Enter Closing Time" required class="form-control">
                                        <br>
                                        <input type="number" name="ticketValue" placeholder="Enter Ticket Value" required class="form-control">
                                        <br>
                                        <input type="number" name="capacity" placeholder="Enter capacity Value" required class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="botons-chico" data-dismiss="modal">Close</button>
                                    <button formaction="<?php echo FRONT_ROOT ?>Cinema/AddCinema" class="botons-chico" type="submit">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})</script>
</main>
<br>
<br>
<br>
<br>
<br>