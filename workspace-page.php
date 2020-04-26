<?php
// include('connectdb.php');
require('connectdb.php');
require('workspace-actions.php');
require('utils.php');

// steps: 
// 1. establish a connection (configure: load driver, specify host, specify username/password)
// 2. preparing query
// 3. bind value, execute
// 4. use result(s) 
// 5. close connection
?>

<?php
//$group_ID = $_POST['group_ID']
$msg = '';
// Get information from cookie
$email = array_key_exists('email', $_COOKIE) ? $_COOKIE['email'] : 'email not found in cookie';
$workspace_name = array_key_exists('workspace_name', $_COOKIE) ? $_COOKIE['workspace_name'] : 'workspace_name not found in cookie';

$workspace_name = 'DB';

setcookie('workspace_name',$_COOKIE['workspace_name']=$workspace_name);

// Check if logged in
$user = getUser($email);
if (!empty($_POST['create-list']))
{
  if (!empty($_POST['title'])) {
    newListNoGroup($_POST['title'], $_POST['description'], $email, $workspace_name);
  }
  else {
    $msg = "Enter list title to create a list";
  }
}  else if (!empty($_POST['create-group'])) {
  if (!empty($_POST['name']))
    newGroup($_POST['name'], $_POST['description'], $email, $workspace_name);
  else 
    $msg = "Enter name title to create a group";
}
    

if (!empty($_POST['action']))
{
    if ($_POST['action'] == "Remove List")
   {
      if (!empty($_POST['list_ID']) ) {
        removeListWorkspace($_POST['list_ID'], $workspace_name, $email);
      }
   }
   else if ($_POST['action'] == "Share List")
   {
      if (!empty($_POST['user_select']) ) {
        shareList($_POST['user_select'],$_POST['list_ID']);
      }   
   } else if ($_POST['action'] == "View List")
   {
      if (!empty($_POST['list_ID']) ) {
        setcookie("list_ID",$_POST['list_ID']);
        header('Location: /cs4750/priorities/items.php');
      }   
   }else if ($_POST['action'] == "View Group")
   {
      if (!empty($_POST['group_ID']) ) {
        setcookie("group_ID",$_POST['group_ID']);
        header('Location: /cs4750/priorities/group.php');
      }   
   }else if ($_POST['action'] == "Remove Group") {
     if (!empty($_POST['group_ID']) ){
       removeGroup($_POST['group_ID'], $workspace_name, $email);
      }
  }
  else if ($_POST['action'] == "Move Into Group") {
    if (!empty($_POST['group_select']) & !empty($_POST['list_ID']) ){
      echo "Moving ".$_POST['list_ID']." into group: ".$_POST['group_select'];
      moveListIntoGroup($_POST['list_ID'], $_POST['group_select'], $workspace_name, $email);
     }
 } else if ($_POST['action'] == "Move to Different Workspace")
 {
    if (!empty($_POST['list_ID']) & !empty($_POST['workspace_switched']) ) {
      SwitchListWorkspace($email, $workspace_name, $_POST['workspace_switched'], $_POST['list_ID']);
    }
 }
}

echo $msg;
$lists = getAllListsRelevantNoGroup($email, $workspace_name);
$groups = getAllGroups($email, $workspace_name);
$user_workspaces = getAllOtherWorkspaces($email, $workspace_name);

// } else {
//   $lists = getAllListsRelevantGroup($group_ID);
// }


?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">      
  <title>Database interfacing</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <button><a href="/cs4750/priorities/workspace-page.php">Go back to <?php echo $email?> Page</a></button>  
</head>

<body>
<div class="container">
<br/>
<a href="/CS4750/priorities/profile.php" class="btn btn-info" role="button">Profile</a>
<a href="/CS4750/priorities/logout.php" class="btn btn-warning" role="button">Logout</a>
<h1>Groups</h1>
<form action="workspace-page.php" method="post">
  <div class="form-group">
    Group Name:
    <input type="text" class="form-control" name="name" placeholder="Enter a group name">        
  </div>  
  <div class="form-group">
    Description:
    <input type="text" class="form-control" name="description" placeholder="Enter a description [optional]">        
  </div> 
  
  <div class="form-group">
    <input type="submit" value="Create Group" class="btn btn-dark" name="create-group" title="Create Group"/>
    <small class="text-danger"><?php echo $msg ?></small>
  </div>  
</form>
<h4>Groups In This Workspace</h4>
    <table class="table table-striped table-bordered">
      <tr>
        <th>Group ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>      
      <?php foreach ($groups as $group): ?>
      <tr>
        <td>
          <?php echo $group['group_ID']; ?> 
        </td>
        <td>
          <?php echo $group['group_name']; ?> 
        </td>        
        <td>
          <?php echo $group['description']; ?> 
        </td>                
        <td>
        <form action="workspace-page.php" method="post">
            <input type="submit" value="View Group" name="action" class="btn btn-primary" />      
            <input type="hidden" name="group_ID" value="<?php echo $group['group_ID'] ?>" />  
          </form>         
        </td>                        
        <td>
          <form action="workspace-page.php" method="post">
            <input type="submit" value="Remove Group" name="action" class="btn btn-danger" />      
            <input type="hidden" name="group_ID" value="<?php echo $group['group_ID'] ?>" />
          </form>
        </td>                               
      </tr>
      <?php endforeach; ?>
    </table>
<br/>
<h1>Lists</h1>
<form action="workspace-page.php" method="post">
  <div class="form-group">
    Title:
    <input type="text" class="form-control" name="title" placeholder="Enter a title">        
  </div>  
  <div class="form-group">
    Description:
    <input type="text" class="form-control" name="description" placeholder="Enter a description [optional]">        
  </div> 
  
  <div class="form-group">
    <input type="submit" value="Create List" class="btn btn-dark" name="create-list" title="Create List"/>
    <small class="text-danger"><?php echo $msg ?></small>
  </div>  
</form>

<h4>Lists In This Workspace</h4>
    <table class="table table-striped table-bordered">
      <tr>
        <th>List ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <!-- <th>&nbsp;</th> -->
      </tr>      
      <?php foreach ($lists as $list): ?>
      <tr>
        <td>
          <?php echo $list['list_ID']; ?> 
        </td>
        <td>
          <?php echo $list['title']; ?> 
        </td>        
        <td>
          <?php echo $list['description']; ?> 
        </td>                
        <td>
          <form action="workspace-page.php" method="post">
            <input type="submit" value="View List" name="action" class="btn btn-primary" />      
            <input type="hidden" name="list_ID" value="<?php echo $list['list_ID'] ?>" />  
          </form>
        </td>                        
        <td>
          <form action="workspace-page.php" method="post">
            <input type="submit" value="Remove List" name="action" class="btn btn-danger" />      
            <input type="hidden" name="list_ID" value="<?php echo $list['list_ID'] ?>" />
          </form>
        </td>
        <td>
          <form action="workspace-page.php" method="post">
            <input type="submit" value="Share List" name="action" class="btn btn-info" />      
            <select name="user_select">
            <?php foreach (getUserEmails($list['list_ID']) as $user):?>
                <option value="<?php echo $user['email']?>"><?php echo $user['email']?></option>
              <?php endforeach; ?>
              
            </select>
            <input type="hidden" name="list_ID" value="<?php echo $list['list_ID'] ?>" />  
          </form>
        </td>
        <td>
          <form action="workspace-page.php" method="post">
            <input type="submit" value="Move Into Group" name="action" class="btn btn-info" />      
            <select name="group_select">
            <?php foreach ($groups as $group):?>
                <option value="<?php echo $group['group_ID']?>"><?php echo $group['group_name']?></option>
              <?php endforeach; ?>
            </select>
            <input type="hidden" name="list_ID" value="<?php echo $list['list_ID'] ?>" />  
          </form>
        </td> 
        <td>
          <form action="workspace-page.php" method="post">
          <input type="submit" value="Move to Different Workspace" name="action" class="btn btn-info" />      
            <select name="workspace_switched">
            <?php foreach ($user_workspaces as $w):?>
                <option value="<?php echo $w['workspace_name']?>"><?php echo $w['workspace_name']?></option>
              <?php endforeach; ?>
            </select>
            <input type="hidden" name="list_ID" value="<?php echo $list['list_ID'] ?>" />    
          </form>
        </td>                         
      </tr>
      <?php endforeach; ?>
    </table>
    
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