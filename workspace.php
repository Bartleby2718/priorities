<?php
// include('connectdb.php');
require('connect-db.php');
require('users-db.php');
require('workspace-db.php');

// steps: 
// 1. establish a connection (configure: load driver, specify host, specify username/password)
// 2. preparing query
// 3. bind value, execute
// 4. use result(s) 
// 5. close connection
?>

<?php
$msg = ''; 
// grab user email from login processing form 
// then I will have a string value, and use that email to display name on card 
// this is a  parameter for getUserInfo_by_email() on line 60/63
// $email = 
// $workspace_name =  
 $user_first_name = getAllUsers(); // will change the RHS

if (!empty($_POST['db-btn']))
{
    if (!empty($_POST['workspace_name']))
      addWorkspace($_POST['workspace_name'], $_POST['description'], $email);
    else 
      $msg = "Enter Workspace Name to create a Workspace";
}

if (!empty($_POST['action']))
{
   if ($_POST['action'] == "View")
      $workspace_to_view = getWorkspaceInfo_by_email($_POST['workspace_name']);
   else if ($_POST['action'] == "Remove")
   {
      if (!empty($_POST['workspace_name']) )
        deleteWorkspace($_POST['workspace_name'], $workspace_name, $email);
   }
}

echo $msg;

?>



<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">  
</head>
<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><?php $userinfo = getUserInfo_by_email($users);
										echo $userinfo["first_name"];?></h5>
										
        <p class="card-text"><?php $workspace_info = getWorkspaceInfo_by_email($users);
										echo $userinfo["description"];?></p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
  

	<div class="container">
	<br/>
	<h1>Workspace</h1>
	<form action="workspace.php" method="post">
	  <div class="form-group">
		Title:
		<input type="text" class="form-control" name="workspace_name" placeholder="Enter a Name">        
	  </div>  
	  <div class="form-group">
		Description:
		<input type="text" class="form-control" name="description" placeholder="Enter a description [optional]">        
	  </div> 
	  
	  <div class="form-group">
		<input type="submit" value="Create Workspace" class="btn btn-dark" name="db-btn" title="Create Workspace"/>
		<small class="text-danger"><?php echo $msg ?></small>
	  </div>  
	</form>


    
</div>    
</body>
</html>
