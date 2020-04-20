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
$friend_to_update = '';

if (!empty($_POST['db-btn']))
{
   if ($_POST['db-btn'] == "Create")           {   create_table();  }
   else if ($_POST['db-btn'] == "Drop")        {   drop_table();    }  
   else if ($_POST['db-btn'] == "View")
   {
      if (!empty($_POST['name']) && !empty($_POST['major']) && !empty($_POST['year']))
         addFriend($_POST['name'], $_POST['major'], $_POST['year']);
      else 
         $msg = "Enter friend's information to insert";
   }
   else if($_POST['db-btn'] == "Confirm-update")  
   {
      if (!empty($_POST['name']) && !empty($_POST['major']) && !empty($_POST['year']))
         updateFriendInfo($_POST['name'], $_POST['major'], $_POST['year']);
      else
         $msg = "Enter friend's information to update";
   }
}

if (!empty($_POST['action']))
{
   if ($_POST['action'] == "Update")
      $friend_to_update = getFriendInfo_by_name($_POST['name']);
   else if ($_POST['action'] == "Delete")
   {
      if (!empty($_POST['name']) )
         deleteFriend($_POST['name']);
   }
}

$lists = getAllLists();

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
<form action="list-actions.php" method="post">
  <div class="form-group">
    Name:
    <input type="text" class="form-control" name="name" value="<?php if (!empty($friend_to_update)) echo $friend_to_update['name'] ?>" />        
  </div>  
  <div class="form-group">
    Major:
    <input type="text" class="form-control" name="major" value="<?php if (!empty($friend_to_update)) echo $friend_to_update['major'] ?>"/>        
  </div>  
  <div class="form-group">
    Year:
    <input type="text" class="form-control" name="year" value="<?php if (!empty($friend_to_update)) echo $friend_to_update['year'] ?>" />        
  </div> 
  
  <div class="form-group">
    <input type="submit" value="Create" class="btn btn-dark" name="db-btn" title="Create 'friends' table"/>
    <input type="submit" value="Drop" class="btn btn-dark" name="db-btn" title="Drop 'friends' table" />
    <input type="submit" value="Insert" class="btn btn-dark" name="db-btn" title="Insert into 'friends' table" />
    <input type="submit" value="Confirm-update" class="btn btn-dark" name="db-btn" title="Update 'friends' info" />
    <small class="text-danger"><?php echo $msg ?></small>
  </div>  
</form>

<h4>List of Lists In This Workspace</h4>
    <table class="table table-striped table-bordered">
      <tr>
        <th>list_ID</th>
        <th>title</th>
        <th>description</th>
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
          <form action="list-actions.php" method="post">
            <input type="submit" value="View" name="action" class="btn btn-primary" />             
            <input type="hidden" name="name" value="<?php echo $list['list_ID'] ?>" />
          </form> 
        </td>                        
        <td>
          <form action="list-actions.php" method="post">
            <input type="submit" value="Delete" name="action" class="btn btn-danger" />      
            <input type="hidden" name="name" value="<?php echo $friend['name'] ?>" />
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