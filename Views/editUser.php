<?php

use Models\UserRole; ?>

<br>
<br>
<br>
<br>
<h2 class="title-secondary">Edit Account Information</h2>
<div class="user_add_div">
    <div class="container-fluid">
        <form action="<?php echo FRONT_ROOT ?>Session/Edit" method="POST">
            <br>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4 offset-4">
                        <input type="text" name="username" required value="<?php echo $name ?>" class="form-control form-control-lg" required />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-4 offset-4">
                    <input type="password" name="password" class="form-control form-control-lg" required value="<?php echo $password ?>" />
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-lg-4 offset-4">
                    <input type="email" name="email" required class="form-control form-control-lg" value="<?php echo $email ?>" />
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-4 offset-4">
                    <input type="number" name="dni" required class="form-control form-control-lg" value="<?php echo $dni ?>" min="5000000" max="99999999" />
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 offset-4">
                    <input type="date" name="birthday" class="form-control form-control-lg" required value="<?php echo $birthday ?>" />
                    <br>
                    <br>
                </div>
            </div>
            <br>
            <div class="row">
                <button class="btn btn-primary offset-6 btn-md active" type="submit">Enviar</button>
            </div>
            <br>
        </form>
        <form action="<?php echo FRONT_ROOT ?>Home" method="POST">
                <button class="btn btn-primary offset-6 btn-md active" type="submit">Home</button>
        </form>
    </div>
</div>

<br>