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
