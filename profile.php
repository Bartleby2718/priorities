<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Items page</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Simple CSS file to verify that it works -->
    <link rel="stylesheet" href="index.css" />
</head>


<?php


// Import functions
require('profile-db.php');

// Get information from cookie
$email = array_key_exists('email', $_COOKIE) ? $_COOKIE['email'] : 'email not found in cookie';

$numbers = getNumbers($email);

if (!empty($_POST['change-pass']))
{
	changePassword($email, $_POST['password']);
}
else if (!empty($_POST['new-number'])) {
	addNumber($email, $_POST['number']);
}
else if (!empty($_POST['new-number'])) {
	addNumber($email, $_POST['number']);
}
else if (!empty($_POST['remove-number'])){
	echo "hey hey hey ";
	echo $_POST['phoneNum'];
	deleteNumber($email, $_POST['phoneNum']);
}


?>
<body>
<div class="container">
<h1> Profile Page</h1>

<h4>Phone Numbers: </h4>

<table class="table table-bordered">
    <!-- Headers -->
    <tr>
        <th>Phone Number</th>
        <th>&nbsp;</th>
    </tr>
    <!-- Existing items -->
    <?php foreach ($numbers as $one_number) :  ?>
    <tr>
            <td>
                <?php echo $one_number['phoneNumber']; ?>
            </td>
            
        <td>
            <form action="profile.php" method="post">
                <input type="hidden" name="phoneNum" value="<?php echo $one_number['phoneNumber'] ?>" />
                <input type="submit" value="Remove" name="remove-number" class="btn btn-danger" />
            </form>
        </td>
    </tr>

    <?php endforeach; ?>
	<form action="profile.php" method="post">
		<tr>
			<td>
				<input type="text" class="form-control" name="number" placeholder="Add a phone number" required />
			</td>
			<td>
				<input type="submit" value="Add Number" name="new-number" class="btn btn-dark" />  
			</td>
		</tr>
	</form>
</table>
    <!-- Change password -->
<form action="profile.php" method="post">   
  <div class="form-group">
    <h4>Change Your Password to:</h4>
    <input type="text" class="form-control" name="password" required />        
  </div>  
  <input type="submit" value="Change" name="change-pass" class="btn btn-dark" />  
  
</form> 
</div>
</body>
