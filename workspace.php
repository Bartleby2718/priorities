<?php
// include('connectdb.php');
require('connectdb.php');
// require('users-db.php');
require('workspace-db.php');
//require('workspace-page.php');
require('utils.php');

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

$email = array_key_exists('email', $_COOKIE) ? $_COOKIE['email'] : 'email not found in cookie';
$user = getUser($email);

$description = 'This is my primary workspace';

setrawcookie('email', $_COOKIE['email'] = $email);

if (!empty($_POST['create_workspace'])) {
    echo "Creating";
    if (!empty($_POST['title'])) {
        newWorkspace($email, $_POST['title'], $_POST['description']);
    } else {
        $msg = "Enter workspace title to create a workspace";
    }
}

if (!empty($_POST['action'])) {
    if ($_POST['action'] == "View Workspace") {
        if (!empty($_POST['workspace_name'])) {
            setcookie("workspace_name", $_POST['workspace_name']);
            header('Location: workspace-page.php');
        }
    } else if ($_POST['action'] == "Remove Workspace") {
        if (!empty($_POST['workspace_name'])) {
            if ($_POST['workspace_name'] == "primary") {
                echo "Can't delete this workspace";
            } else {
                deleteWorkspace($_POST['workspace_name'], $email);
            }
        }
    }
}

$workspaces = getWorkspaceInfo_by_email($email);

?>



<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Dashboard</title>
</head>

<body>
    <div class="container">
        <br />

        <h1>Dashboard</h1>
        <h4>Add Workspace</h4>
        <form action="workspace.php" method="post">
            <div class="form-group">
                Title:
                <input type="text" class="form-control" name="title" placeholder="Enter a Name">
            </div>
            <div class="form-group">
                Description:
                <input type="text" class="form-control" name="description" placeholder="Enter a description">
            </div>

            <div class="form-group">
                <input type="submit" value="Create Workspace" class="btn btn-dark" name="create_workspace" title="Create Workspace" />
            </div>
        </form>
        <a href="reminders.php" class="btn btn-primary" style="background-color:green">Reminders</a>
        <a href="profile.php" class="btn btn-primary" style="background-color:pink">Profile</a>
        <a href="assigned.php" class="btn btn-secondary">Items assigned to me</a>
        <a href="logout.php" class="btn btn-warning" role="button">Logout</a>
        <div class="row">
            <div class="col-sm-6">
                <h4>Workspaces for <?php echo $email ?></h4>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    <?php foreach ($workspaces as $w) : ?>
                        <tr>
                            <td>
                                <?php echo $w['workspace_name']; ?>
                            </td>
                            <td>
                                <?php echo $w['description']; ?>
                            </td>
                            <td>
                                <form action="workspace.php" method="post">
                                    <input type="submit" value="View Workspace" name="action" class="btn btn-primary" />
                                    <input type="hidden" name="workspace_name" value="<?php echo $w['workspace_name'] ?>" />
                                </form>
                            </td>
                            <td>
                                <form action="workspace.php" method="post">
                                    <input type="submit" value="Remove Workspace" name="action" class="btn btn-danger" />
                                    <input type="hidden" name="workspace_name" value="<?php echo $w['workspace_name'] ?>" />
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            </div>


        </div>
</body>

</html>