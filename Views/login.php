<main class="main">
     <h1 class="title-principal">Welcome to MOVIE PASS</h1>
     <div class="login-form">

          <h2>Log-in</h2>

          <form method="post">

               <input type="text" name="username" class="form-group" placeholder="Enter User" required>
               <input type="password" name="password" class="form-group" placeholder="Enter Password" required>


               <button formaction="<?php echo FRONT_ROOT ?>Session/Login" class="botons" type="submit">Log-In</button>
               <button formaction="<?php echo FRONT_ROOT ?>FacebookSession/Index" class="botons" type="submit">
                    <span>Login with Facebook</span>
               </button>
          </form>

          <form method="post">
               <button name="action" value="register" formaction="<?php echo FRONT_ROOT ?>Session" class="register-btn bts-a" type="submit">
                    Don't have an account? Sign up!
               </button>
          </form>
     </div>
     </div>
</main>