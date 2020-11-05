<main class="main">
  <h1 class="title-principal">Welcome to MOVIE PASS</h1>
  <div class="login-form">
    <h2>Choose an option</h2>
    <form method="POST">

      <button formaction="<?php echo FRONT_ROOT ?>FacebookSession/Index" class="botons" type="submit">
        Facebook</button>

    </form>


    <form action="<?php echo FRONT_ROOT ?>Session/Index" method="POST">

      <button class="botons" type="submit" name="action" value="register"> Register </button>

    </form>


    <form action="<?php echo FRONT_ROOT ?>Session/Index" method="POST">

      <button class="botons" type="submit" name="action" value="login">Login</button>

    </form>

    <form action="<?php echo FRONT_ROOT ?>Session/Index" method="POST">

      <button class="botons" type="submit" name="action" value="login">Billboard</button>

    </form>

  </div>

</main>