<?php
// File containing functions that interact with the database

// Require database conection
require('connectdb.php');

// SELECT
function getReminders($email)
{
    global $db;
    $query = "SELECT * FROM reminder as r
              INNER JOIN item as i ON r.item_ID = i.item_ID
              WHERE email=:email ORDER BY r.item_ID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();
    return $results;
}

// SELECT
function getRemindableItems($email)
{
    global $db;
    // TODO: Restrict to the items that the user belongs?
    $query = "SELECT * FROM item ORDER BY item_ID;";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();
    return $results;
}

// INSERT
function createReminder($email, $item_ID, $date_time, $message)
{
    global $db;
    $query = "INSERT INTO reminder (email, item_ID, date_time, message)
              VALUES (:email, :item_ID, :date_time, :message);";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':item_ID', $item_ID);
    $statement->bindValue(':date_time', $date_time);
    $statement->bindValue(':message', $message);
    $statement->execute();
    $statement->closeCursor();
}

// UPDATE
function updateReminder($email, $item_ID, $date_time, $message, $reminder_ID)
{
    global $db;
    $query = "UPDATE reminder
              SET item_ID=:item_ID, date_time=:date_time, message=:message
              WHERE reminder_ID=:reminder_ID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':item_ID', $item_ID);
    $statement->bindValue(':message', $message);
    $statement->bindValue(':date_time', $date_time);
    $statement->bindValue(':reminder_ID', $reminder_ID);
    $statement->execute();
    $statement->closeCursor();
}

// DELETE
function deleteReminder($reminder_ID)
{
    global $db;
    $query = "DELETE FROM reminder WHERE reminder_ID = :reminder_ID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':reminder_ID', $reminder_ID);
    $statement->execute();
    $statement->closeCursor();
}
