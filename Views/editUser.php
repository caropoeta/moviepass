<h2 class="title-secondary">Edit Information</h2>
<div class="login-form" style="margin: auto">
    <div style="margin: auto">
        <div class="form-group" style="margin: auto">
            <form action="<?php echo FRONT_ROOT ?>Session/Edit" method="POST">
                <br>
                <div>
                    <div>
                        <div>
                            <label>Name:</label>
                            <input type="text" name="username" required value="<?php echo $name ?>" class="form-control form-control-lg" required />
                        </div>
                    </div>
                </div>
                <br>
                <div>
                    <div>
                        <label>Password</label>
                        <input type="password" name="password" class="form-control form-control-lg" required value="<?php echo $password ?>" />
                    </div>
                </div>

                <br>
                <div>
                    <div>
                        <label>Email:</label>
                        <input type="email" name="email" required class="form-control form-control-lg" value="<?php echo $email ?>" />
                    </div>
                </div>
                <br>
                <div>
                    <div>
                        <label>DNI:</label>
                        <input type="number" name="dni" required class="form-control form-control-lg" value="<?php echo $dni ?>" min="5000000" max="99999999" />
                        <br>
                    </div>
                </div>
                <div>
                    <div>
                        <label>Birthday:</label>
                        <input type="date" name="birthday" class="form-control form-control-lg" required value="<?php echo $birthday ?>" />
                        <br>
                        <br>
                    </div>
                </div>
                <br>
                <div style="margin: auto">
                    <button class="botons" type="submit">Enviar</button>
                </div>
                <br>
            </form>
            <form action="<?php echo FRONT_ROOT ?>Home" method="POST">
            <button  class="botons" type="submit">Home</button>
        </form>
        </div>
        
    </div>
</div>
<br>