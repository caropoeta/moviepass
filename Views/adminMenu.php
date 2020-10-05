<?php
echo '<hr>';
echo 'Admin';
echo '<hr><br>';
if ($_SESSION['current_user'])
  var_dump($_SESSION['current_user']);
?>

<body>
<div>
    <form action="<?php echo FRONT_ROOT ?>Log/Logout" method="POST">
      <button type="submit"> Logout </button>
    </form>

    <form action="<?php echo FRONT_ROOT ?>Users/List" method="POST">
      <button type="submit"> User list </button>
    </form>
  </div>
</body>