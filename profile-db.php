<?php
// File containing functions that interact with the database
// for profiles: editing phone numbers or password

// Require database conection
require('connectdb.php');

// SELECT
function getNumbers($email)
{
    global $db;
    $query = "SELECT phoneNumber FROM user_phone WHERE email=:email;";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

// INSERT
function addNumber($email, $number)
{
    global $db;
    $query = "INSERT INTO user_phone(email, phoneNumber)
              VALUES (:email, :number);";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':number', $number);
    $statement->execute();
    $statement->closeCursor();
}

// DELETE
function deleteNumber($email, $number)
{
    global $db;
    $query = "DELETE FROM user_phone WHERE email = :email AND phoneNumber=:number;";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':number', $number);
    $statement->execute();
    $statement->closeCursor();
}

//UPDATE PASSWORD
function changePassword($email, $password)
{
    global $db;
    $query = "UPDATE users SET password=SHA2(:password, 256) WHERE email=:email;";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->closeCursor();
}
