<?php
// Import functions
require('item-db.php');

// Fetch data from POST request body
// Required fields
$email = $_POST['email'];
$item_ID = $_POST['item_ID'];

// TODO: Check user_email?

// Run SQL query
unassignItem($email, $item_ID);

// Redirect to items page
header("Location: /cs4750/priorities/items.php");
die();
