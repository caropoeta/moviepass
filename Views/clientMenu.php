<?php
echo '<hr>';
echo 'Client';
echo '<hr><br>';
if ($_SESSION['current_user'])
  var_dump($_SESSION['current_user']);
?>

<body>
  <div>
    <form action="<?php echo FRONT_ROOT ?>Session/Logout" method="POST">
      <button type="submit"> Logout </button>
    </form>
  </div>
</body>