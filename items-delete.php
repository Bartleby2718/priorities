<?php
// Import functions
require('item-db.php');

// Fetch data from POST request body
$item_ID = $_POST['item_ID'];

// TODO: Check user_email?

// Run SQL query
deleteItem($item_ID);

// Redirect to items page
header("Location: /cs4750/items.php");
die();
