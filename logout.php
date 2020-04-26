<?php 
setcookie('email', "", time() - 3600);

header("Location: /CS4750/priorities/login.php");
exit();

?>