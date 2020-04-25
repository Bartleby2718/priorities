


	
	<?php
// include('connectdb.php');
require('connectdb.php');
require('login-db.php');

// steps: 
// 1. establish a connection (configure: load driver, specify host, specify username/password)
// 2. preparing query
// 3. bind value, execute
// 4. use result(s) 
// 5. close connection
?>


<?php
//$email = $_POST['email']
//$workspace_name = $_POST['workspace_name']
//$group_ID = $_POST['group_ID']
$msg = '';
// $email = $_GET['email'];
// $workspace_name = $_GET['workspace_name'];
$group_ID = $_COOKIE['group_ID'];
$email = $_COOKIE['email'];
$workspace_name = $_COOKIE['workspace_name'];
echo $group_ID;

if (!empty($_POST['login']))
{
	$acc_email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
	$acc_pass = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
	$confirmed_email = CheckCreds($acc_email, $acc_pass)
	if (isset($confirmed_email)){
		setcookie('email', $confirmed_email);
	}	
}
if (!empty($_POST['new-account']))
{
	$acc_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
	$acc_pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	$acc_fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
	$acc_lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
	NewAccount($acc_email, $acc_pass, $acc_fname, $acc_lname);
	if (isset($_POST['phone'])){
		$acc_phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
		AddPhone($acc_email,$acc_phone);
	}	
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">      
  <title>Priorities Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<div class="container">
<h1>Login</h1>
<form action="login-std.php" method="post">   
  <div class="form-group">
    Your email:
    <input type="text" class="form-control" name="email" required />        
  </div>  
  <div class="form-group">
    Password:
    <input type="text" class="form-control" name="password" required />        
  </div>  
  <input type="submit" value="Login" name="login" class="btn btn-dark" />  
  
</form>  
<h1>Create account</h1>
<form action="login-new.php" method="post">   
  <div class="form-group">
    Your email:
    <input type="text" class="form-control" name="email" required />        
  </div>  
  <div class="form-group">
    Password:
    <input type="text" class="form-control" name="password" required />        
  </div>  
  <div class="form-group">
    First Name:
    <input type="text" class="form-control" name="fname" required />        
  </div>  
  <div class="form-group">
    Last Name:
    <input type="text" class="form-control" name="lname" required />        
  </div> 
  <div class="form-group">
    Phone number:
    <input type="text" class="form-control" name="phone" />        
  </div>  

  <input type="submit" value="Create Account" name="new-account" class="btn btn-dark" />  
  
</form>  

    
</div>    
</body>
</html>


<?php 

// isset() takes the name of a variable as its argument and
// return TRUE only if that variable value is not NULL
// (thus, ensuring that the variable has been set with some value)

// Empty form fields will be NULL unless the user has entered a value.

// empty() accepts a variable argument and
// returns TRUE if its value is an empty string, zero, NULL or FALSE

?>