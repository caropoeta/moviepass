<nav>
    <div class="logo">
      <h4 style="float:right; margin-top:10px; margin-right: 20px">MOVIE PASS </h4>
    </div>
    <ul  class="nav-links">
    <form style="margin-top:10px "method="POST">
      <li><a href="<?php echo FRONT_ROOT ?>Billboard/List">Billboard</a></li>
      <li><a href="<?php echo FRONT_ROOT ?>Ticket/List">Tickets</a></li>
      <li><button 
                  formaction="<?php echo FRONT_ROOT ?>Session/Index" 
                  class="btn btn-secondary" 
                  type="submit" 
                  name="action" 
                  value="edit"
                  >Edit acount </button></li>
      <li><a href="<?php echo FRONT_ROOT ?>Session/Logout">Logout</a></li>
    </form>
    </ul>
  </nav>

