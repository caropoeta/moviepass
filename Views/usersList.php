<section>
    <?php
    include('navbaradmin.php');

    use Models\UserModel as UserModel;
    use Models\UserRole as UserRole;
    ?>

</section>
<section>
    <div>
        <br>
        <!-- user_list-->
        <div class="login-form">
            <div>
                <h2>Search Users</h2>
                <br>
                <div class="form-group" style="margin:auto">
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
                <button type="button" class="botons" data-toggle="modal" data-target="#addUser">
                    Add User
                </button>
            </div>

            <hr>

            <h2>Users</h2>
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
                                        Edit
                                    </button>
                                    <form method="POST">
                                        <button class="botons-chico" formaction="<?php echo FRONT_ROOT ?>Users/Delete" type="submit" name="id" value="<?php echo $user->getId(); ?>">Delete</button>
                                    <hr>
                                </form>
                                <br>
                                <hr>
                            <?php } ?>
                        </form>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
    <!-- Modal adduser -->
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUser" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="addUser">Add User</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="text" name="username" required placeholder="Username" class="form-group" required />
                        <input type="password" name="password" class="form-group" required placeholder="Password" />
                        <input type="email" name="email" class="form-group" placeholder="Email" />
                        <input type="number" name="dni" class="form-group" placeholder="Number" min="5000000" max="99999999" />
                        <input type="date" name="birthday" class="form-group" required placeholder="Birthday" />

                        <h2>Rol</h2>

                        <select class="form-group">
                            <?php foreach ($roles as $role) {
                                if ($role instanceof UserRole) { ?>
                                    <option class="options"><?php echo $role->getName(); ?></option>
                            <?php }
                            } ?>
                        </select>
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="botons-chico" data-dismiss="modal">Close</button>
                    <button formaction="<?php echo FRONT_ROOT ?>Users/Add" class="botons-chico" type="submit">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="<?php echo 'usuario' . $user->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edituser">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div id="task<?php echo $user->getId() ?>"></div>
                                        <input type="email" name="email" value="<?php echo $user->getEmail() ?>" class="form-group" required placeholder="Update Email" />
                                        <input type="number" name="dni" value="<?php echo $user->getDni() ?>" class="form-group" required placeholder=" Update Id" />
                                        <input type="date" name="birthday" value="<?php echo $user->getBirthday() ?>" class="form-group" required placeholder=" Update Date" />

                                        <h2>Rol</h2>
                                        <select class="form-group" name="role">
                                            <?php
                                            foreach ($roles as $role) {
                                                if ($role instanceof UserRole) {
                                                    if ($user->getRole() == $role->getName()) { ?>
                                                        <option class="options" selected="selected" value="available">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option class="options">
                                                        <?php } ?>

                                                        <?php echo $role->getName(); ?></option>

                                                <?php
                                                }
                                            } ?>
                                        </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="botons-chico" data-dismiss="modal">Close</button>
                    <button formaction="<?php echo FRONT_ROOT ?>Users/Edit" class="botons-chico" type="submit" name="id" value="<?php echo $user->getId() ?>">Edit</button>
                </div>
            </div>
        </div>
    </div>
    

</section>