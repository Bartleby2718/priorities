<?php
// Import functions
require('item-db.php');

// Fetch data from POST request body
// Required fields
$list_ID = $_POST['list_ID'];
$description = $_POST['description'];
// Optional fields -> set to NULL
$date_time_due = array_key_exists('date_time_due', $_POST) ? $_POST['date_time_due'] : NULL;

// TODO: Check user_email?

// Run SQL query
createItem($list_ID, $description, $date_time_due);

// Redirect to items page
header("Location: items.php");
die();
