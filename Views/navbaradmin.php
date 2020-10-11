<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <form method="POST">
          <div class="p-2">
            <button formaction="<?php echo FRONT_ROOT ?>Session/Logout" class="btn btn-secondary" type="submit" name="action" value="register"> Log Out </button>
          </div>

      </li>

      <li class="nav-item">

        <div class="p-2">
          <button formaction="<?php echo FRONT_ROOT ?>Users/List" class="btn btn-secondary" type="submit" name="action" value="login">UsersList</button>
        </div>
      </li>

      <li class="nav-item">

        <div class="p-2">
          <button formaction="<?php echo FRONT_ROOT ?>Api/List" class="btn btn-secondary" type="submit">ApiList</button>
        </div>
        </form>
      </li>
    </ul>

  </div>
</nav>