<?php
// File containing functions that interact with the database

// Require database conection
require('connectdb.php');

// SELECT
function getItems($list_ID)
{
    global $db;
    $query = "SELECT * FROM item WHERE list_ID=:list_ID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':list_ID', $list_ID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
	
    return $results;
}

// INSERT
function createItem($list_ID, $description, $date_time_due)
{
    global $db;
    // Get current datetime
    $date_time_created = date('Y-m-d H:i:s');
    $query = "INSERT INTO item
              (list_ID, description, date_time_created, date_time_due)
              VALUES (:list_ID, :description, :date_time_created, :date_time_due);";
    $statement = $db->prepare($query);
    $statement->bindValue(':list_ID', $list_ID);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':date_time_created', $date_time_created);
    $statement->bindValue(':date_time_due', $date_time_due);
    $statement->execute();
    $statement->closeCursor();
}

// UPDATE
function updateItem($item_ID, $description, $date_time_due)
{
    global $db;
    // Get current datetime
    $query = "UPDATE item
              SET description=:description, date_time_due=:date_time_due
              WHERE item_ID=:item_ID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':item_ID', $item_ID);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':date_time_due', $date_time_due);
    $statement->execute();
    $statement->closeCursor();
}

// DELETE
function deleteItem($item_ID)
{
    global $db;
    $query = "DELETE FROM item WHERE item_ID = :item_ID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':item_ID', $item_ID);
    $statement->execute();
    $statement->closeCursor();
}
