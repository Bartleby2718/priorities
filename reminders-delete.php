<?php
// Import functions
require('reminders-db.php');

// Fetch data from POST request body
$reminder_ID = $_POST['reminder_ID'];

// TODO: Check user_email?

// Run SQL query
deleteReminder($reminder_ID);

// Redirect to reminders page
header("Location: reminders.php");
die();
