<?php
setcookie('email', "", time() - 3600);
setcookie("list_ID", "", time() - 3600);
setcookie("group_ID", "", time() - 3600);
setcookie("workspace_name", "", time() - 3600);

session_unset();
session_destroy();

header("Location: login.php");
exit();
