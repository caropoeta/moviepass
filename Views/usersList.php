<?php

use Models\UserModel as UserModel;
use Models\UserRole as UserRole;
?>

<div>
    <!-- user_add_form-->
    <div>
        <h2>Agregar usuario</h2>

        <form action="<?php echo FRONT_ROOT ?>Users/Add" method="POST">
            <input type="text" name="username" required />
            <input type="password" name="password" required />
            <input type="email" name="email" required />
            <input type="number" name="dni" required />
            <input type="date" name="birthday" required />

            <div>
                <label for="">Rol</label>
                <select name="role">
                    <?php foreach ($roles as $role) {
                        if ($role instanceof UserRole) { ?>
                            <option><?php echo $role->getName(); ?></option>
                    <?php }
                    } ?>
                </select>
            </div>

            <button type="submit">Agregar</button>
        </form>
    </div>

    <?php echo '<hr>'; ?>

    <!-- user_list-->
    <div>
        <h2>Usuarios</h2>
        <div>
            <?php foreach ($users as $user) {
                if ($user instanceof UserModel) { ?>
                    <?php echo $user->getName(); ?>

                    <?php if ($user->getId() != $_SESSION['current_user']->getId()) { ?>

                        <!-- user_delete_form-->
                        <div id="task<?php echo $user->getId() ?>" uk-modal>
                            <form action="<?php echo FRONT_ROOT ?>Users/Delete" method="POST">
                                <button type="submit" name="id" value="<?php echo $user->getId() ?>">Borrar</button>
                            </form>
                        </div>

                        <!-- user_edit_form-->
                        <div id="task<?php echo $user->getId() ?>" uk-modal>
                            <form action="<?php echo FRONT_ROOT ?>Users/Edit" method="POST">
                                <input type="email" name="email" value="<?php echo $user->getEmail() ?>" required />
                                <input type="number" name="dni" value="<?php echo $user->getDni() ?>" required />
                                <input type="date" name="birthday" value="<?php echo $user->getBirthday() ?>" required />

                                <div>
                                    <label for="">Rol</label>
                                    <select name="role" value="<?php echo $user->getRole() ?>">
                                        <?php foreach ($roles as $role) {
                                            if ($role instanceof UserRole) { ?>
                                                <option><?php echo $role->getName(); ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>

                                <button type="submit" name="id" value="<?php echo $user->getId() ?>">Editar</button>
                            </form>
                        </div>
                    <?php }
                    echo '<hr>'; ?>
            <?php }
            } ?>
        </div>
    </div>
</div>

<?php include('footer.php') ?>