<?php
// Import functions
require('reminders-db.php');

// Fetch data from POST request body
// Required fields
// email and item_ID are optional as per the current schema...
$email = $_POST['email'];
$item_ID = $_POST['item_ID'];
$date_time = $_POST['date_time'];
$message = $_POST['message'];
// TODO: Check user_email?

// Run SQL query
createReminder($email, $item_ID, $date_time, $message);

// Redirect to reminders page
header("Location: /cs4750/priorities/reminders.php");
die();
