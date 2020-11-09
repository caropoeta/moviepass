<main class="main ">
     <div class="login-form">

          <header class="text-center">
               <h2>Register</h2>
          </header>
               <form action="<?php echo FRONT_ROOT ?>Session/Register" method="post">

                    <div class="form-group">
                         <label for="">User</label>
                         <input type="text" name="username" class="form-control " placeholder="User" required>
                    </div>
                    <div class="form-group">
                         <label for="">Password</label>
                         <input type="password" name="password" class="form-control " placeholder="Password" required>
                    </div>
                    <div class="form-group">
                         <label for="">DNI</label>
                         <input type="number" name="dni" class="form-control " placeholder="DNI" required minlength="7" maxlength="8">
                    </div>
                    <div class="form-group">
                         <label for="">Email</label>
                         <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                         <label for="">BirthDay</label>
                         <input type="date" name="birthday" class="form-control" placeholder="BirthDay" required pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}">
                    </div>
                    <button class="botons" type="submit">Send Register</button>
                    <br>

               </form>
               <form method="post">
                    <button formaction="<?php echo FRONT_ROOT ?>home/MainPage" class="botons" type="submit">Return to Index</button>
               </form>
          
     </div>
</main>