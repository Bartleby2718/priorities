<?php
// File containing functions that interact with the database

// Require database conection
require('connectdb.php');

// CHECK IF EMAIL?PASS COMBO IS VALID
function CheckCreds($email, $password)
{
    global $db;
    $query = "SELECT email FROM users WHERE email=:email AND password=SHA2(:password, 256);";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
	$statement->bindValue(':password', $password);
    $statement->execute();
    $results = $statement->fetchColumn();
    $statement->closeCursor();
	return $results;
}

function CreateUser($email, $password, $fname, $lname)
{
    global $db;
    $query = "INSERT INTO users(email, password, first_name, last_name) 
VALUES(:email, SHA2(:password, 256), :first_name, :last_name);";
    $statement = $db->prepare($query);
    $statement->bindValue(':email',  $email);
	$statement->bindValue(':password', $password );
	$statement->bindValue(':first_name', $fname);
	$statement->bindValue(':last_name', $lname);
    $statement->execute();
    $statement->closeCursor();
	return $email;

}

function AddPhone($email, $phone){
	global $db;
    $query = "INSERT INTO user_phone(email, phoneNumber) 
VALUES(':email', ':phoneNumber');";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
	$statement->bindValue(':phoneNumber', $phone);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
	return; 	
}

?>