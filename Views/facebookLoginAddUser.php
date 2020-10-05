<div>
    <form action="<?php echo FRONT_ROOT ?>Log/Register" method="POST">
        <input type="text" name="username" required />
        <input type="password" name="password" required />
        <input type="number" name="dni" required />
        <input type="email" name="email" required />
        <input type="date" name="birthday" required />

        <button type="submit">Register</button>
    </form>
</div>