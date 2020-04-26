<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reminders page</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Simple CSS file to verify that it works -->
    <link rel="stylesheet" href="index.css" />
</head>

<body>
    <?php
    // Import functions
    require('reminders-db.php');
    require('utils.php');

    // Get information from cookie
    $email = array_key_exists('email', $_COOKIE) ? $_COOKIE['email'] : 'email not found in cookie';
    echo 'email in the cookie: ', $email, '<br>';

    $user = getUser($email);
    $reminders = getReminders($email);
    $items = getRemindableItems($email);
    ?>

    <h4>Reminders for <?php echo $user['first_name']; ?></h4>
    <table class="table table-striped table-bordered" id="myTable">
        <!-- Headers -->
        <tr class="text-center">
            <th>Reminder ID</th>
            <th>Item</th>
            <th>Date</th>
            <th>Message</th>
            <th></th>
            <th></th>
        </tr>
        <!-- Existing reminders -->
        <?php foreach ($reminders as $reminder) : ?>
        <tr>
            <form action="reminders-update.php" method="post">
                <td class="text-center">
                    <?php echo $reminder['reminder_ID']; ?>
                </td>
                <td class="text-center">
                    <select class="form-control" name="item_ID">
                        <option disabled selected value>Select an item</option>
                        <?php foreach ($items as $item) : ?>
                        <option value="<?php echo $item['item_ID'] ?>" <?php echo $item['item_ID'] === $reminder['item_ID'] ? "selected" : ""; ?>><?php echo  $item['description'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type='date' name='date_time' value="<?php echo Date('Y-m-d', strtotime($reminder['date_time'])); ?>" class="form-control" required />
                </td>
                <td>
                    <input type="text" name="message" placeholder="What do you want us to tell you?" class="form-control" value="<?php echo $reminder['message'] ?>" required>
                </td>
                <td class="text-center">
                    <input type="hidden" name="reminder_ID" value="<?php echo $reminder['reminder_ID'] ?>" />
                    <input type="hidden" name="email" value="<?php echo $email ?>" />
                    <input type="submit" value="Update" class="btn btn-info" />
                </td>
            </form>
            <td class="text-center">
                <form action="reminders-delete.php" method="post">
                    <input type="hidden" name="reminder_ID" value="<?php echo $reminder['reminder_ID'] ?>" />
                    <input type="hidden" name="email" value="<?php echo $email ?>" />
                    <input type="submit" value="Remove" class="btn btn-danger" />
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <!-- New reminder -->
        <form action="reminders-create.php" method="post">
            <tr>
                <td class="text-center">
                    <!-- "reminder_ID" is automatically added later.-->
                    Create a new reminder!
                </td>
                <td>
                    <select class="form-control" name="item_ID">
                        <option disabled selected value>Select an item</option>
                        <?php foreach ($items as $item) : ?>
                        <option value="<?php echo $item['item_ID'] ?>"><?php echo $item['description'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <!-- TODO: Improve date widget later -->
                    <input type="date" name="date_time" class="form-control" required>
                </td>
                <td>
                    <input type="text" name="message" placeholder="What do you want us to tell you?" class="form-control" required>
                </td>
                <td class="text-center">
                    <input type="hidden" name="email" value="<?php echo $email ?>" />
                    <input type="submit" value="Create" class="btn btn-primary" />
                </td>
                <td class="text-center">
                </td>
            </tr>
        </form>
    </table>

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
