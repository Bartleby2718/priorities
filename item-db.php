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

// SELECT (get Assignees)
function getAssignees($item_ID)
{
    global $db;
    $query = "SELECT * from item_assignment_connection
              WHERE item_ID=:item_ID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':item_ID', $item_ID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();
    return $results;
};

// INSERT (item)
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

// INSERT (assign item)
function assignItem($email, $item_ID)
{
    global $db;
    $query = "INSERT INTO item_assignment_connection (email, item_ID) 
              VALUES (:email, :item_ID);";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':item_ID', $item_ID);
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

// DELETE (unassign item)
function unassignItem($email, $item_ID)
{
    global $db;
    $query = "DELETE FROM item_assignment_connection
              WHERE email=:email AND item_ID=:item_ID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':item_ID', $item_ID);
    $statement->execute();
    $statement->closeCursor();
}
