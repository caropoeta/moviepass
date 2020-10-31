<section>
    <?php
    include('navbaradmin.php');

    use Models\UserModel as UserModel;
    use Models\UserRole as UserRole;
    ?>
</section>
<section class="">
    <div>
        <br>
        <!-- user_list-->
        <div class="login-form">
            <h2>Search Users</h2>
            <br>
            <div class="form-group">
                <br>
                <form action="<?php echo FRONT_ROOT ?>Users/List" method="POST">

                    <input type="text" class="form-group" name="name" placeholder="Enter user name">

                    <input type="email" class="form-group" name="email" placeholder="Enter user email">

                    <input type="text" class="form-group" name="dni" placeholder="Enter user dni">
                    <select class=" form-group" name="role">
                        <option default>Anything</option>
                        <?php
                        foreach ($roles as $role) {
                            if ($role instanceof UserRole) {
                        ?>
                                <option class="options"><?php echo $role->getName(); ?></option>
                        <?php }
                        } ?>
                    </select>
                    <button class="botons" type="submit">Search</button>
                </form>
            </div>
            <h2>Users</h2>
            <hr>
            <?php foreach ($users as $user) {
                if ($user instanceof UserModel) { ?>
                    <div class>
                        <br>
                        <form>
                            <label><?php echo $user->getName(); ?>
                            </label>
                            <br>
                            <?php if ($user->getId() != $_SESSION['current_user']->getId()) { ?>
                                <button type="button" class="botons-chico" data-toggle="modal" data-target="<?php echo '#usuario' . $user->getId(); ?>">
                                    Editar
                                </button>
                                <form method="POST">
                                    <button class="botons-chico" formaction="<?php echo FRONT_ROOT ?>Users/Delete" type="submit" name="id" value="<?php echo $user->getId(); ?>">Borrar</button>
                                </form>
                                <br>
                        </form>

                        <!-- Modal -->
                        <div class="modal-content" id="<?php echo 'usuario' . $user->getId(); ?>">
                            <div class="modal">
                                <form method="POST">
                                    <div class="modal-header">
                                        <br>
                                        <h2>Editar usuario</h2>
                                        
                                    </div>

                                    <div class="modal-body">
                                        <div id="task<?php echo $user->getId() ?>"></div>
                                        <br>
                                        <input type="email" name="email" value="<?php echo $user->getEmail() ?>" class="form-control form-control-lg" required placeholder="Update Email" />
                                        <br>
                                        <input type="number" name="dni" value="<?php echo $user->getDni() ?>" class="form-control form-control-lg" required placeholder=" Update Id" />
                                        <br>
                                        <input type="date" name="birthday" value="<?php echo $user->getBirthday() ?>" class="form-control form-control-lg" required placeholder=" Update Date" />

                                        <h2>Rol</h2>
                                        <br>
                                        <div class="form-group">
                                        <select class="options-modal" name="role">


                                            <?php
                                            foreach ($roles as $role) {
                                                if ($role instanceof UserRole) {
                                                    if ($user->getRole() == $role->getName()) { ?>
                                                        <option selected="selected" value="available">
                                                        <?php
                                                    } else {
                                                        ?>
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
                                        <button formaction="<?php echo FRONT_ROOT ?>Users/Edit" class="botons" type="submit" name="id" value="<?php echo $user->getId() ?>">Editar</button>
                                        <button type="button" class="botons" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
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

            <br>

            <div class="col-auto">
                <button type="button" class="botons" data-toggle="modal" data-target="#add">
                    Add user
                </button>
            </div>

            <div class="modal-content" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                   <div class="modal">
                       <div class="login-form">
                        <form method="POST">
                            <div class="modal-header">
                                <br>
                                <h2>Add user</h2>
                            </div>
                            <div class="modal-body">
                                <br>
                                <div >
                                    <div class="row">
                                        <div class="col-lg-4 offset-4">
                                            <input type="text" name="username" required placeholder="Username" class="form-group" required />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4 offset-4">
                                        <input type="password" name="password" class="form-group" required placeholder="Password" />
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-lg-4 offset-4">
                                        <input type="email" name="email" required class="form-group" placeholder="Email" />
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4 offset-4">
                                        <input type="number" name="dni" required class="form-group" placeholder="Number" min="5000000" max="99999999" />
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 offset-4">
                                        <input type="date" name="birthday" class="form-group" required placeholder="Birthday" />
                                        <br>
                                        <br>
                                    </div>
                                </div>

                                <div class="row">
                                    <h2">Rol</h2>

                                </div>
                                <div class="form-group">
                                    <select class="options-modal">
                                        <?php foreach ($roles as $role) {
                                            if ($role instanceof UserRole) { ?>
                                                <option><?php echo $role->getName(); ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                    <br>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button formaction="<?php echo FRONT_ROOT ?>Users/Add" class="botons" type="submit">Add</button>
                                <button type="button" class="botons" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>