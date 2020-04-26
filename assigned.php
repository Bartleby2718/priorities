<!DOCTYPE html>
<html>
<?php
// Import functions
require('item-assigned.php');
require('utils.php');

// Get information from cookie
$email = array_key_exists('email', $_COOKIE) ? $_COOKIE['email'] : 'email not found in cookie';

$user = getUser($email);
$items = getAssignedItems($email);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Items assigned to me</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Simple CSS file to verify that it works -->
    <link rel="stylesheet" href="index.css" />
</head>

<body>
    <button><a href="workspace.php">Go back to dashboard</a></button>
    <h4>Items assigned to <?php echo $user['first_name']; ?></h4>
    <table class="table table-striped table-bordered" id="myTable">
        <!-- Headers -->
        <tr class="text-center">
            <th>Description</th>
            <th>Due Date</th>
            <th>Date Created</th>
        </tr>
        <!-- Existing items -->
        <?php foreach ($items as $item) : ?>
        <tr>
            <td class="text-center">
                <?php echo  $item['description'] ?>
            </td>
            <td class="text-center">
                <!-- no due date -->
                <?php if ($item['date_time_due'] === null) : ?>
                -
                <!-- has due date -->
                <?php else :
                        $formatted_date = Date('Y-m-d', strtotime($item['date_time_due']));
                        echo
                            '<input type="date" name="date_time_due" value="',
                            $formatted_date,
                            '" class="form-control" disabled';
                    endif; ?>
            </td>
            <td class="text-center">
                <?php echo  $item['date_time_created'] ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
