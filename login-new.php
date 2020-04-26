<?php
// Import functions
require('login-db.php');

// Fetch data from POST request body
// Required fields
$acc_email = $_POST['email'];
$acc_pass = $_POST['password'];
$acc_fname = $_POST['fname'];
$acc_lname = $_POST['lname'];
CreateUser($acc_email, $acc_pass, $acc_fname, $acc_lname);
if (isset($_POST['phone'])) {
	$acc_phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
	AddPhone($acc_email, $acc_phone);
}
setrawcookie('email', $_COOKIE['email'] = $acc_email);

// Redirect to items page

header("Location: /cs4750/priorities/workspace.php");
exit();
