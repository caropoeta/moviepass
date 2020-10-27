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
                            <button type="submit" class="btn btn-primary offset-4">Show Cinemas</button>
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

                <div class="col-auto">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary offset-4" data-toggle="modal" data-target="#add">
                        Add cinema
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
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
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button formaction="<?php echo FRONT_ROOT ?>Cinema/AddCinema" class="btn btn-primary offset-6 btn-md active" type="submit">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>