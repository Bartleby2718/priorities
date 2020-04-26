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
        header("Location: /cs4750/priorities/login.php");
        die();
    }
    return $results;
}

function getList($workspace_name)
{
    global $db;
    $query = "SELECT * FROM lists WHERE workspace_name=:workspace_name;";
    $statement = $db->prepare($query);
    $statement->bindValue(':workspace_name', $workspace_name);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closeCursor();
    if (!is_array($results)) {
        // Redirect to the workspace page if workspace_name invalid
        header("Location: /cs4750/priorities/workspace-page.php");
        die();
    }
    return $results;
}
