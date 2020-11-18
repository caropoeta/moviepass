<nav>
  <div class="logo">
    <h4 style="float:left;  margin-top:30px; margin-right: 350px">MOVIE PASS Welcome <?php if(isset($_SESSION['user']))echo $_SESSION['user']; ?> </h4>
  </div>
  <ul class="nav-links">
 
      <li><a href="<?php echo FRONT_ROOT ?>Billboard/List">Billboard</a></li>
      <li><a href="<?php echo FRONT_ROOT ?>Ticket/List">Tickets</a></li>
      <li><a href="<?php echo FRONT_ROOT ?>Session/Index/edit">Edit Acount</a></li>
      <li><a href="<?php echo FRONT_ROOT ?>Session/Logout">Logout</a></li>
     
  
    

  
  </ul>
</nav>