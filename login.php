<?php
// include('connectdb.php');
require('login-db.php');

// steps: 
// 1. establish a connection (configure: load driver, specify host, specify username/password)
// 2. preparing query
// 3. bind value, execute
// 4. use result(s) 
// 5. close connection
if (array_key_exists('email', $_COOKIE)) {
    header("Location: workspace.php");
    exit();
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
        <br />
        <h1>Login</h1>
        <form action="login-std.php" method="post">
            <div class="form-group">
                Your email:
                <input type="text" class="form-control" name="email" required />
            </div>
            <div class="form-group">
                Password:
                <input type="password" class="form-control" name="password" required />
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
                <input type="text" class="form-control" name="password" input-typrequired />
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