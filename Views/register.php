<main class="d-flex align-items-center justify-content-center height-100">
     <div class="content">
          <header class="text-center">
               <br>
               <h2 class="Ctext">MoviePass Register Form</h2>
          </header>

          <form action="<?php echo FRONT_ROOT ?>Log/Register" method="post" class="login-form bg-dark-alpha p-5 bg-light">

               <div class="form-group">
                    <label for="">User</label>
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="User" required>
               </div>
               <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
               </div>
               <div class="form-group">
                    <label for="">DNI</label>
                    <input type="number" name="dni" class="form-control form-control-lg" placeholder="DNI" required>
               </div>
               <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
               </div>
               <div class="form-group">
                    <label for="">BirthDay</label>
                    <input type="date" name="birthday" class="form-control form-control-lg" placeholder="BirthDay" required>
               </div>
               <button class="btn btn-primary btn-block btn-lg" type="submit">Send Registration Form</button>
          </form>
     </div>
</main>