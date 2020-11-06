<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">

      <li class="nav-item">

        <div class="p-2">
          <form method="POST">
            <button formaction="<?php echo FRONT_ROOT ?>Session/Logout" class="btn btn-secondary" type="submit"> Log-Out </button>
            <button formaction="<?php echo FRONT_ROOT ?>Session/Index" class="btn btn-secondary" type="submit" name="action" value="edit"> Edit account information </button>
            <button formaction="<?php echo FRONT_ROOT ?>Ticket/List" class="btn btn-outline-success" type="submit">Ticket List</button>
            <button formaction="<?php echo FRONT_ROOT ?>Billboard/List" class="btn btn-secondary" type="submit"> Billboard </button>

          </form>
        </div>

      </li>
    </ul>
  </div>
</nav>