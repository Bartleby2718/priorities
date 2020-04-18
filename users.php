<?php 

function create_table()
{
   global $db;
   $query = "CREATE TABLE IF NOT EXISTS users (
             email VARCHAR(255) PRIMARY KEY,
             password VARCHAR(255),
			 first_name VARCHAR(255),
             last_name VARCHAR(255))";
	
   $statement = $db->prepare($query);
   $statement->execute();
   $statement->closeCursor();
}


function drop_table()
{
   global $db;
   $query = "DROP TABLE users";
	
   $statement = $db->prepare($query);
   $statement->execute();
   $statement->closeCursor();
}


function getAllUsers()
{
   global $db;
   $query = "select * from users";
   $statement = $db->prepare($query);
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   $results = $statement->fetchAll();
	
   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();
	
   return $results;
}


function getUserInfo_by_email($email)
{
   global $db;
	
   $query = "select * from friends where email = :email";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   // fetch() return a row
   $results = $statement->fetch();
	
   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();
	
   return $results;
}


function addUser($email, $password, $first_name, $last_name)
{
   global $db;
	
   // insert into users (email, password, first_name, last_name) values ('sa2dt@virginia.edu', 'password', 'Sonia', 'Aggarwal');
   $query = "INSERT INTO friends VALUES (:email, :password, :first_name, :last_name)";
   
   echo "addFriend: $email : $password : $first_name $last_name <br/>";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':password', $password);
   $statement->bindValue(':first_name', $first_name);
   $statement->bindValue(':last_name', $last_name);
   $statement->execute();     // if the statement is successfully executed, execute() returns true
   // false otherwise
		
   $statement->closeCursor();
}


function updateUserInfo($email, $password, $first_name, $last_name)
{
   global $db;
	
   // update users set password="pw1010" where email="chief@cia.gov"
   $query = "UPDATE users SET password=:password, first_name=:first_name, last_name=:last_name WHERE email=:email";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':password', $password);
   $statement->bindValue(':first_name', $first_name);
   $statement->bindValue(':last_name', $last_name);
   $statement->execute();
   $statement->closeCursor();
}




function deleteUser($email)
{
   global $db;
	
   $query = "DELETE FROM users WHERE email=:email";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->execute();
   $statement->closeCursor();
}
?>

