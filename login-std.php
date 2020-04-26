<?php
// Import functions
require('login-db.php');

// Fetch data from POST request body
// Required fields
$acc_email = $_POST['email'];
$acc_pass = $_POST['password'];


$confirmed_email = CheckCreds($acc_email, $acc_pass);
echo $confirmed_email;
if(! ($confirmed_email == false)){
	setcookie('email',$_COOKIE['email']=$confirmed_email);
// Redirect to items page
	header("Location: /CS4750/priorities/workspace.php");
	exit();
}
header("Location: /CS4750/priorities/login.php");
exit();
