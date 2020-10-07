<main class="d-flex align-items-center justify-content-center height-100">
     <div class="content">
          <header class="text-center">
               <h2 class="Ctext">Movie Pass Log-in</h2>
          </header>
          <div class="login-form bg-dark-alpha p-5 bg-light">
               <form method="post">

                    <div class="form-group">
                         <label for="">User</label>
                         <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter User" required>
                    </div>
                    <div class="form-group">
                         <label for="">Password</label>
                         <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter Password" required>
                    </div>

                    <button formaction="<?php echo FRONT_ROOT ?>Log/Login" class="btn btn-primary btn-block btn-lg" type="submit">Log-In</button>
                    <button formaction="<?php echo FRONT_ROOT ?>FacebookLog/Login" class="fblogin social btn btn-primary btn-block btn-lg" type="submit">
                         <span>Login with Facebook</span>
                    </button>
               </form>

               <form method="post">
                    <button name="action" value="register" formaction="<?php echo FRONT_ROOT ?>Log" class="register-btn bts-a" type="submit">
                         Don't have an account? Sign up!
                    </button>
               </form>
          </div>
     </div>
</main>