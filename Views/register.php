<main class="main">

     <div class="login-form">
          <form action="<?php echo FRONT_ROOT ?>Session/Register" method="post">
               <h2>Register Form</h2>

               <input type="text" name="username" class="form-group" placeholder="Enter your user" required>
               <input type="password" name="password" class="form-group" placeholder="Enter your password" required>
               <input type="number" name="dni" class="form-group" placeholder="Enter your DNI" required minlength="7" maxlength="8">
               <input type="email" name="email" class="form-group" placeholder="Enter your email" required>
               <input type="date" name="birthday" class="form-group" placeholder="Enter your birthDay" required pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}">
          </form>
     <button class="botons" type="submit">Register</button>
     <br>
     <form method="post">
          <button formaction="<?php echo FRONT_ROOT ?>home/MainPage" class="botons" type="submit">Return to Index</button>
     </form>
</div>
</main>