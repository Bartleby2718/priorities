<?php 
setcookie('email', "", time() - 3600);

header("Location: /cs4750/priorities/login.php");
exit();

?>