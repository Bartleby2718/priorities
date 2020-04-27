<?php
// Import functions
require('item-db.php');

// Fetch data from POST request body
$item_ID = $_POST['item_ID'];
$description = array_key_exists('description', $_POST) ? $_POST['description'] : NULL;
$date_time_due = array_key_exists('date_time_due', $_POST) ? $_POST['date_time_due'] : NULL;

// TODO: Check user_email?

// Run SQL query
updateItem($item_ID, $description, $date_time_due);

// Redirect to items page
header("Location: items.php");
die();
