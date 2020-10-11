<?php
include('navbaradmin.php');

use Models\UserModel as UserModel;
use Models\UserRole as UserRole;
?>

<div>
    <br>
    <!-- user_list-->
    <div class="user_list_div">
        <h2 class="text-center fuente3 ">Usuarios</h2>
        <br>
        <div class="container">

            <?php foreach ($users as $user) {
                if ($user instanceof UserModel) { ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-sm-2 control-label"><?php echo $user->getName(); ?></label>
                        </div>

                        <?php if ($user->getId() != $_SESSION['current_user']->getId()) { ?>
                            <div class="col-auto">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="<?php echo '#usuario' . $user->getId(); ?>">
                                    Editar
                                </button>
                            </div>

                            <div class="col-auto">
                                <form method="POST">
                                    <button class="btn btn-primary mb-2" formaction="<?php echo FRONT_ROOT ?>Users/Delete" type="submit" name="id" value="<?php echo $user->getId(); ?>">Borrar</button>
                                </form>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" id="<?php echo 'usuario' . $user->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="task<?php echo $user->getId() ?>" uk-modal></div>
                                                <br>
                                                <div>
                                                    <div class="col-md-4 offset-4">
                                                        <input type="email" name="email" value="<?php echo $user->getEmail() ?>" class="form-control form-control-lg" required placeholder="Update Email" />
                                                    </div>
                                                </div>
                                                <br>
                                                <div>
                                                    <div class="col-md-4 offset-4">
                                                        <input type="number" name="dni" value="<?php echo $user->getDni() ?>" class="form-control form-control-lg" required placeholder=" Update Id" />
                                                    </div>
                                                </div>
                                                <br>
                                                <div>
                                                    <div class="col-md-4 offset-4">
                                                        <input type="date" name="birthday" value="<?php echo $user->getBirthday() ?>" class="form-control form-control-lg" required placeholder=" Update Date" />
                                                    </div>
                                                </div>
                                                <div>
                                                    <div>
                                                        <h3 class="text-center fuente5 offset-6">Rol</h3>
                                                    </div>
                                                    <select class="custom-select col-md-4 offset-4" name="role">
                                                        <?php foreach ($roles as $role) {
                                                            if ($role instanceof UserRole) {
                                                                if ($user->getRole() == $role->getName()) { ?>
                                                                    <option selected="selected" value="available">
                                                                    <?php } else { ?>
                                                                    <option>
                                                                    <?php } ?>

                                                                    <?php echo $role->getName(); ?></option>

                                                            <?php
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <br>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button formaction="<?php echo FRONT_ROOT ?>Users/Edit" class="btn btn-primary offset-6 btn-md active" type="submit" name="id" value="<?php echo $user->getId() ?>">Editar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                    <hr>

            <?php
                }
            }
            ?>
        </div>
    </div>
    <br>
    <!-- user_add_form-->
    <div class="user_add_div">
        <h2 class=" text-center fuente">Agregar usuario</h2>
        <div class="container-fluid">
            <form action="<?php echo FRONT_ROOT ?>Users/Add" method="POST">
                <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4 offset-4">
                            <input type="text" name="username" required placeholder="Username" class="form-control form-control-lg" required />
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-4 offset-4">
                        <input type="password" name="password" class="form-control form-control-lg" required placeholder="Password" />
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-lg-4 offset-4">
                        <input type="email" name="email" required class="form-control form-control-lg" placeholder="Email" />
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-4 offset-4">
                        <input type="number" name="dni" required class="form-control form-control-lg" placeholder="Number" min="6" max="8" />
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 offset-4">
                        <input type="date" name="birthday" class="form-control form-control-lg" required placeholder="Birthday" />
                        <br>
                        <br>
                    </div>
                </div>

                <div class="row">
                    <h3 class=" text-center fuente5 offset-6">Rol</h3>

                </div>
                <div class="row">
                    <select class="custom-select col-lg-4 offset-4" name="role">
                        <?php foreach ($roles as $role) {
                            if ($role instanceof UserRole) { ?>
                                <option><?php echo $role->getName(); ?></option>
                        <?php }
                        } ?>
                    </select>
                    <br>
                </div>
                <br>
                <div class="row">
                    <button class="btn btn-primary offset-6 btn-md active" type="submit">Agregar</button>
                    <br>
                </div>
            </form>
        </div>
    </div>
    <br>
</div>
<hr>