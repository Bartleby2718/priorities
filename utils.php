<?php
// File containing utility functions

// Require database conection
require('connectdb.php');

function getUser($email)
{
    global $db;
    $query = "SELECT * FROM users WHERE email=:email;";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closecursor();
    if (!is_array($results)) {
        // Redirect to the login page if not logged in
        header("Location: login.php");
        die();
    }
    return $results;
}

function getList($list_ID)
{
    global $db;
    $query = "SELECT * FROM lists WHERE list_ID=:list_ID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':list_ID', $list_ID);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closeCursor();
    if (!is_array($results)) {
        // Redirect to the workspace page if list_ID invalid
        header("Location: workspace-page.php");
        die();
    }
    return $results;
}
