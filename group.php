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
$msg = '';
$email = array_key_exists('email', $_COOKIE) ? $_COOKIE['email'] : 'email not found in cookie';
$workspace_name = array_key_exists('workspace_name', $_COOKIE) ? $_COOKIE['workspace_name'] : 'workspace_name not found in cookie';
$group_ID = array_key_exists('group_ID', $_COOKIE) ? $_COOKIE['group_ID'] : 'group_ID not found in cookie';

// Check if logged in
$user = getUser($email);

if (!empty($_POST['db-btn'])) {
    if (!empty($_POST['title']))
        newListGroup($_POST['title'], $_POST['description'], $group_ID);
    else
        $msg = "Enter list title to create a list";
}

if (!empty($_POST['action'])) {
    if ($_POST['action'] == "Remove") {
        if (!empty($_POST['list_ID']))
            removeListGroup($_POST['list_ID'], $group_ID);
    } else if ($_POST['action'] == "View List") {
        if (!empty($_POST['list_ID'])) {
            setcookie("list_ID", $_POST['list_ID']);
            header('Location: items.php');
        }
    } else if ($_POST['action'] == "Share") {
        if (!empty($_POST['user_select']) & !empty($_POST['list_ID'])) {
            shareList($_POST['user_select'], $_POST['list_ID']);
        }
    } else if ($_POST['action'] == "Move Back to Workspace") {
        if (!empty($_POST['list_ID'])) {
            MoveFromGrouptoList($_POST['list_ID'], $group_ID, $workspace_name, $email);
        }
    }
}

echo $msg;
$lists = getAllListsRelevantGroup($group_ID);


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="your name">
    <meta name="description" content="include some description about your page">
    <title>Group Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <button><a href="workspace-page.php">Go back to dashboard</a></button>
</head>

<body>
    <div class="container">
        <br />
        <h1>Lists</h1>
        <form action="group.php" method="post">
            <div class="form-group">
                Title:
                <input type="text" class="form-control" name="title" placeholder="Enter a title">
            </div>
            <div class="form-group">
                Description:
                <input type="text" class="form-control" name="description" placeholder="Enter a description [optional]">
            </div>

            <div class="form-group">
                <input type="submit" value="Create List" class="btn btn-dark" name="db-btn" title="Create List" />
                <small class="text-danger"><?php echo $msg ?></small>
            </div>
        </form>

        <h4>Lists In This Group</h4>
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
            </tr>
            <?php foreach ($lists as $list) : ?>
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
                        <form action="group.php" method="post">
                            <input type="submit" value="View List" name="action" class="btn btn-primary" />
                            <input type="hidden" name="list_ID" value="<?php echo $list['list_ID'] ?>" />
                        </form>
                    </td>
                    <td>
                        <form action="group.php" method="post">
                            <input type="submit" value="Remove" name="action" class="btn btn-danger" />
                            <input type="hidden" name="list_ID" value="<?php echo $list['list_ID'] ?>" />
                        </form>
                    </td>
                    <td>
                        <form action="workspace-page.php" method="post">
                            <input type="submit" value="Share List with:" name="action" class="btn btn-info" />
                            <select name="user_select" class="form-control">
                                <?php foreach (getUserEmails($list['list_ID']) as $user) : ?>
                                    <option value="<?php echo $user['email'] ?>"><?php echo $user['email'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="list_ID" value="<?php echo $list['list_ID'] ?>" />
                        </form>
                    </td>
                    <td>
                        <form action="group.php" method="post">
                            <input type="submit" value="Move Back to Workspace" name="action" class="btn btn-secondary" />
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