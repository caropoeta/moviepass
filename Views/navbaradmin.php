  <nav>
    <div class="logo">

      <h4 style="float:right; margin-top:23px; margin-right: 20px">MOVIE PASS ADMIN</h4>
    </div>
    <ul class="nav-links">
      <li><a href="<?php echo FRONT_ROOT ?>Billboard/List"> Billboard </a></li>
      <li><a href="<?php echo FRONT_ROOT ?>Users/List">Users</a></li>
      <li><a href="<?php echo FRONT_ROOT ?>Cinema">Cinemas</a></li>
      <li><a href="<?php echo FRONT_ROOT ?>Session/Index">Edit </a></li>
      <li class="nav-item dropdown">
        <a href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Movies
        </a>
        <div class="dropdown-menu" style="background-color: #a5a4a4" aria-labelledby="navbarDropdown">
          <a class="dropdown-item"href="<?php echo FRONT_ROOT ?>Api/List">API</a>
          <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Movies/List">Saved Movies</a>
        </div>
      </li>
      <li><a href="<?php echo FRONT_ROOT ?>Session/Logout">Logout</a></li>
    </ul>
  </nav>