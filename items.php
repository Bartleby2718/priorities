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
echo 'Welcome to item page!';

// Import functions
require('item-db.php');

// Get information from cookie
$email = array_key_exists('email', $_COOKIE) ? $_COOKIE['email'] : 'email not found in cookie';
$workspace_name = array_key_exists('workspace_name', $_COOKIE) ? $_COOKIE['workspace_name'] : 'workspace_name not found in cookie';
$list_ID = array_key_exists('list_ID', $_COOKIE) ? $_COOKIE['list_ID'] : 'list_ID not found in cookie';

echo 'email in the cookie: ', $email, '<br>';
echo 'workspace_name in the cookie: ', $workspace_name, '<br>';
echo 'list_ID in the cookie: ', $list_ID, '<br>';

echo '<br>';
echo 'Show all items in a given list:', '<br>';
$items = getItems($list_ID);
?>

<h4>Items for List ID <?php echo $list_ID; ?></h4>
<table class="table table-striped table-bordered">
    <!-- Headers -->
    <tr>
        <th>Item ID</th>
        <th>List ID</th>
        <th>Description</th>
        <th>Date Created</th>
        <th>Date Due</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
    <!-- Existing items -->
    <?php foreach ($items as $list) : ?>
    <tr>
        <form action="items-update.php" method="post">
            <td>
                <?php echo $list['item_ID']; ?>
            </td>
            <td>
                <?php echo $list['list_ID']; ?>
            </td>
            <td>
                <input type="text" name="description" value="<?php echo $list['description']; ?>" />
            </td>
            <td>
                <?php echo $list['date_time_created']; ?>
            </td>
            <td>
                <!-- no due date -->
                <?php if ($list['date_time_due'] === null) : ?>
                <input type='datetime-local' name='date_time_due'>
                <!-- has due date -->
                <?php else :
                        $formatted_date = Date('Y-m-d\TH:i', strtotime($list['date_time_due']));
                        echo
                            "<input type='datetime-local' name='date_time_due' value='",
                            $formatted_date,
                            "'";
                    endif; ?>
            </td>
            <td>
                <input type="hidden" name="item_ID" value="<?php echo $list['item_ID'] ?>" />
                <input type="submit" value="Update" class="btn btn-info" />
            </td>
        </form>
        <td>
            <form action="items-delete.php" method="post">
                <input type="hidden" name="item_ID" value="<?php echo $list['item_ID'] ?>" />
                <input type="submit" value="Remove" class="btn btn-danger" />
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    <!-- New item -->
    <form action="items-create.php" method="post">
        <tr>
            <td>
                <!-- "item_ID" is automatically added later.-->
                Create a new item!
            </td>
            <td>
                <!-- list_ID column will be deleted later.-->
            </td>
            <td>
                <input type="text" name="description" placeholder="What do you need to do?" required>
            </td>
            <td>
                <!-- "Date Created" is automatically added later.-->
                -
            </td>
            <td>
                <!-- TODO: Improve datetime widget later -->
                <input type="datetime-local" name="date_time_due">
            </td>
            <td>
                <input type="hidden" name="list_ID" value="<?php echo $list_ID ?>" />
                <input type="submit" value="Create" class="btn btn-primary" />
            </td>
            <td>
            </td>
        </tr>
    </form>
</table>
