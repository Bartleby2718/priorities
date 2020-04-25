<?php
// Import functions
require('item-db.php');

// Fetch data from GET request body
$item_ID = $_GET['item_ID'];
// TODO: Check user_email?

// Run SQL query
$assignees = getAssignees($item_ID);
foreach ($assignees as $index =>  $record) {
    foreach ($record as $columnname => $value) {
        if (is_int($columnname)) {
            unset($record[$columnname]);
        }
    }
    $assignees[$index] = $record;
}
$data = ['assignments' => $assignees];
header('Content-Type: application/json');
echo json_encode($data);
