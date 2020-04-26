<?php
// include('connectdb.php');
require('connect-db.php');
require('users-db.php');
require('workspace-db.php');
//require('workspace-page.php');

// steps: 
// 1. establish a connection (configure: load driver, specify host, specify username/password)
// 2. preparing query
// 3. bind value, execute
// 4. use result(s) 
// 5. close connection

// start a new user session
session_start();
?>

<?php
$msg = ''; 
// grab user email from login processing form 
// then I will have a string value, and use that email to display name on card 
// this is a  parameter for getUserInfo_by_email() on line 60/63
$email = 'up3f@virginia.edu';
$workspace_name = 'DB';
$description = 'This is my primary workspace';
 $user_first_name = getAllUsers(); // will change the RHS

setcookie('email',$_COOKIE['email']=$email);
setcookie('workspace_name',$_COOKIE['workspace_name']=$workspace_name);

	if (!empty($_POST['create-workspace']))
	{
	  if (!empty($_POST['title'])) {
		newWorkspace($_POST['title'], $_POST['description'], $email, $workspace_name);
	  }
	  else {
		$msg = "Enter workspace title to create a workspace";
	  }
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

//echo $msg;

//<?php $userinfo = getUserInfo_by_email($users);
//echo $userinfo["first_name"];

//<?php $workspace_info = getWorkspaceInfo_by_email($users);
//echo $userinfo["description"];

// newWorkspace($email, $workspace_name, $description = "")
?>



<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">  
</head>
	
	
	<div class="container">
	<h1>Add Workspace</h1>
	<form action="workspace.php" method="post">
	  <div class="form-group">
		Title:
		<input type="text" class="form-control" name="workspace_name" placeholder="Enter a Name">        
	  </div>  
	  <div class="form-group">
		Description:
		<input type="text" class="form-control" name="description" placeholder="Enter a description">        
	  </div> 
	  
	  <div class="form-group">
		<input type="submit" value="Create Workspace" class="btn btn-dark" name="workspace_submit" title="Create Workspace"/>	
	  </div>
	</form>
	<a href="reminders.php" class="btn btn-primary" style="background-color:green">Reminders</a>	
	<div class="row">
	  <div class="col-sm-6">
		<?php 
		if(array_key_exists("workspace_cards", $_SESSION)) {
			foreach($_SESSION["workspace_cards"] as $title => $card) {
				echo '<form action="workspace.php" method="post">
						<div class="form-group">
							<input type="hidden" name="card_title" value='.$title.' />
						</div>
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">'. $title .'</h5>							
								<p class="card-text">'.  $card->desc .'</p>
								<a href="workspace-page.php" class="btn btn-primary">Go to Workspace</a>
								<input type="submit" value="delete" class="btn btn-dark" name="workspace_delete" title="Delete"/>	
							</div>
						</div>
					</div>';
			}	
		} else {
			echo "<br>No workspaces yet</br>";
		}
		?>	
	</div>
	
 
		  
	<?php	
	class WorkspaceCard {
		var $title;
		var $desc;
		
		function __construct($title, $desc){
			$this->title = $title;
			$this->desc = $desc;
		}
		
	}
	
	if (isset($_POST['workspace_submit'])) {
		if(!array_key_exists("workspace_cards", $_SESSION)) {
			$_SESSION["workspace_cards"] = array();
		}
		echo "<meta http-equiv='refresh' content='0'>";
		//array_push($_SESSION["workspace_cards"], new WorkspaceCard($_POST["workspace_name"], $_POST["description"]));
		$_SESSION["workspace_cards"][$_POST["workspace_name"]] = new WorkspaceCard($_POST["workspace_name"], $_POST["description"]);
		header( "Location: workspace.php" );
		exit;
	
	} else if (isset($_POST['workspace_delete'])) {	
	
		$workspace_name = $_POST['workspace_name'];
		// Run SQL query
		deleteWorkspace($workspace_name);
		
		//print_r($_SESSION["workspace_cards"]);
		if(isset($_SESSION["workspace_cards"])) {
			if(count($_SESSION["workspace_cards"]) == 1) {
				unset($_SESSION["workspace_cards"]);
			} else {
				unset($_SESSION["workspace_cards"][$_POST["card_title"]]);
			}
		}
		header( "Location: workspace.php" );
		exit;
	}
	?>

</div>    
</body>
</html>
