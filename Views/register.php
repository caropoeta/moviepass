<main class="d-flex  justify-content-center ">
     <div class="content">
          
          <header class="text-center">
               <h2 class="fuente4 ">MoviePass Register Form</h2>
          </header>
<div class="login-form bg-dark-alpha p-5 bg-light">
    <form action="<?php echo FRONT_ROOT ?>Session/Register" method="post" >

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
                    <input type="number" name="dni" class="form-control form-control-lg" placeholder="DNI" required minlength="7" maxlength="8">
               </div>
               <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
               </div>
               <div class="form-group">
                    <label for="">BirthDay</label>
                    <input type="date" name="birthday" class="form-control form-control-lg" placeholder="BirthDay" required pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}">
               </div>
               <button class="btn btn-primary btn-block btn-lg" type="submit">Send Registration Form</button>
          </form>
     </div>
</div>
</main>