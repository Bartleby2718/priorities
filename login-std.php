<?php
// Import functions
require('login-db.php');

// Fetch data from POST request body
// Required fields
$acc_email = $_POST['email'];
$acc_pass = $_POST['password'];


$confirmed_email = CheckCreds($acc_email, $acc_pass);
echo $confirmed_email;
if (!($confirmed_email == false)) {
	setrawcookie('email', $_COOKIE['email'] = $confirmed_email);
	// Redirect to items page


	header("Location: workspace.php");
	exit();
}
header("Location: login.php");

exit();
