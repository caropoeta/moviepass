<nav>
  <div class="logo">

    <h4 style="float:left; margin-top:30px; margin-right: 200px">MOVIE PASS Welcome <?php if(isset($_SESSION['user']))echo $_SESSION['user']; ?></h4>
  </div>

  <ul class="nav-links">
    <li><a href="<?php echo FRONT_ROOT ?>Session/Index/edit" >Edit User</a></li>
    <li><a href="<?php echo FRONT_ROOT ?>Ticket/List">Ticket List</a></li>
    <li><a href="<?php echo FRONT_ROOT ?>Users/List">Users</a></li>
    <li><a href="<?php echo FRONT_ROOT ?>Cinema">Cinemas</a></li>
    <li class="nav-item dropdown">
      <a href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Movies </a>
      <div class="dropdown-menu" style="background-color: #a5a4a4" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Api/List">API</a>
        <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Movies/List">Saved Movies</a>
        <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Billboard/List">Billboard</a>
      </div>
    </li>
    <li><a href="<?php echo FRONT_ROOT ?>Session/Logout">Logout</a></li>
    
    
    
    
</ul>
</nav>