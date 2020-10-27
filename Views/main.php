<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
      
        <form method="POST">
            <div class="p-2">
              <button formaction="<?php echo FRONT_ROOT ?>FacebookSession/Index" class="btn btn-primary" type="submit">
                Facebook</button>
            </div>
          </form>
        </form>
      </li>
      <li class="nav-item">
        <form action="<?php echo FRONT_ROOT ?>Session/Index" method="POST">
          <div class="p-2">
            <button class="btn btn-outline-success" type="submit" name="action" value="register"> Register </button>
          </div>
        </form>
      </li>

      <li class="nav-item">
        <form action="<?php echo FRONT_ROOT ?>Session/Index" method="POST">
          <div class="p-2">
            <button class="btn btn-outline-success" type="submit" name="action" value="login">Login</button>
          </div>
        </form>
      </li>
    </ul>

  </div>
</nav>
<main class="d-flex align-items-center justify-content-center height-100">
<div class="container-fluid">


  <h1 class="text-center fuente3"> Movie-Pass </h1>


  <h2 class="text-center fuente4"> Cinema !</h2>



<div class="container-fluid">
  <div id="carousel-example-1z" class="carousel slide carousel-fade" data-ride="carousel" data-interval="1000">
    <!--Indicators-->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-1z" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-1z" data-slide-to="1"></li>
      <li data-target="#carousel-example-1z" data-slide-to="2"></li>
    </ol>
    <!--/.Indicators-->
    <!--Slides-->
    <div class="carousel-inner" role="listbox" d>
      <!--First slide-->
      <div class="carousel-item active">
        <img class="d-block w-100" src="<?php echo FRONT_ROOT . IMG_PATH . 'cine2.png'; ?>" alt="First slide" height="500px" width="250px">
      </div>
      <!--/First slide-->
      <!--Second slide-->
      <div class="carousel-item">
        <img class="d-block w-100" src="<?php echo FRONT_ROOT . IMG_PATH . '2.jpg'; ?>" alt="Second slide" height="500px" width="250px">
      </div>
      <!--/Second slide-->
      <!--Third slide-->
      <div class="carousel-item">
        <img class="d-block w-100" src="<?php echo FRONT_ROOT . IMG_PATH . 'cine.webp'; ?>" alt="Third slide" height="500px" width="250px">
      </div>
      <!--/Third slide-->
    </div>
    <!--/.Slides-->
    <!--Controls-->
    <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</main>
