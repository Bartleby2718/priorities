<?php
// Import functions
require('reminders-db.php');

// Fetch data from POST request body
$email = $_POST['email'];
$item_ID = $_POST['item_ID'];
$date_time = $_POST['date_time'];
$message = $_POST['message'];
$reminder_ID = $_POST['reminder_ID'];
echo $email, $item_ID, $date_time, $message;
// TODO: Check user_email?

// Run SQL query
updateReminder($email, $item_ID, $date_time, $message, $reminder_ID);

// Redirect to reminders page
header("Location: reminders.php");
die();
