<?php
// File containing functions that interact with the database

// Require database conection
require('connectdb.php');

// CHECK IF EMAIL?PASS COMBO IS VALID
function CheckCreds($email, $password)
{
    global $db;
    $query = "SELECT email FROM user WHERE email=:email AND password=HASHBYTES('SHA-2566',:password);";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
	$statement->bindValue(':password', $password);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();
	if(mysql_num_rows($result) == 1){
		return $results;
	}
	return Null;
}

function CreateUser($email, $password, $fname, $lname)
{
    global $db;
    $query = "INSERT INTO users(email, password, first_name, last_name) 
VALUES(':email', HASHBYTES(‘SHA2_256’,':password'), ':first_name', ':last_name');";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
	$statement->bindValue(':password', $password);
	$statement->bindValue(':first_name', $fname);
	$statement->bindValue(':last_name', $lname);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();
	return $email

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
    $statement->closecursor();
	return 	
}

?>