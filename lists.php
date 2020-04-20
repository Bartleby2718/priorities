<?php echo "Hello World @^_^@" ?>
<?php
// include('connectdb.php');
require('connectdb.php');
require('list-actions.php');

// steps: 
// 1. establish a connection (configure: load driver, specify host, specify username/password)
// 2. preparing query
// 3. bind value, execute
// 4. use result(s) 
// 5. close connection
?>

<?php
$msg = '';
$email = 'up3f@virginia.edu';
$workspace_name = 'DB';

if (!empty($_POST['db-btn']))
{
    if (!empty($_POST['title']))
      newList($_POST['title'], $_POST['description']);
    else 
      $msg = "Enter list title to create a list";
}

if (!empty($_POST['action']))
{
   if ($_POST['action'] == "View")
      $list_to_view = getList_by_list_ID($_POST['list_ID']);
   else if ($_POST['action'] == "Remove")
   {
      if (!empty($_POST['list_ID']) )
        removeList($_POST['list_ID'], $workspace_name, $email);
   }
}

echo $msg;
$lists = getAllListsRelevant($email, $workspace_name);

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
</head>

<body>
<div class="container">
<br/>
<h1>Lists</h1>
<form action="lists.php" method="post">
  <div class="form-group">
    Title:
    <input type="text" class="form-control" name="title" value="<?php if (!empty($friend_to_update)) echo $friend_to_update['major'] ?>"/>        
  </div>  
  <div class="form-group">
    Description:
    <input type="text" class="form-control" name="description" value="<?php if (!empty($friend_to_update)) echo $friend_to_update['year'] ?>" />        
  </div> 
  
  <div class="form-group">
    <input type="submit" value="Create List" class="btn btn-dark" name="db-btn" title="Create List"/>
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
          <form action="lists.php" method="post">
            <input type="submit" value="View" name="action" class="btn btn-primary" />             
            <input type="hidden" name="list_ID" value="<?php echo $list['list_ID'] ?>" />
          </form> 
        </td>                        
        <td>
          <form action="lists.php" method="post">
            <input type="submit" value="Remove" name="action" class="btn btn-danger" />      
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