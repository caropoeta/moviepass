<div>
    <form action="<?php echo FRONT_ROOT ?>Log/Login" method="POST">
        <input type="text" name="user" required />
        <input type="password" name="password" required />
        <button type="submit">Login</button>
    </form>

    <form action="<?php echo FRONT_ROOT ?>Log/FacebookLogin" method="POST">
        <button type="submit">FacebookLogin</button>
    </form>
</div>