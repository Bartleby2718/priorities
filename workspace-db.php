<?php 

function workspace_create_table()
{
   global $db;
   $query = "CREATE TABLE IF NOT EXISTS workspace (
             email VARCHAR(255) PRIMARY KEY,
             workspace_name VARCHAR(255),
			 description VARCHAR(255)";
	
   $statement = $db->prepare($query);
   $statement->execute();
   $statement->closeCursor();
}


function workspace_drop_table()
{
   global $db;
   $query = "DROP TABLE workspace";
	
   $statement = $db->prepare($query);
   $statement->execute();
   $statement->closeCursor();
}


function getAllWorkspaces()
{
   global $db;
   $query = "select * from workspace";
   $statement = $db->prepare($query);
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   $results = $statement->fetchAll();
	
   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();
	
   return $results;
}


function getWorkspaceInfo_by_email($email)
{
   global $db;
	
   $query = "select * from workspace where email = :email";
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


function addWorkspace($email, $workspace_name, $description)
{
   global $db;
	
   // insert into users (email, password, first_name, last_name) values ('sa2dt@virginia.edu', 'password', 'Sonia', 'Aggarwal');
   $query = "INSERT INTO workspace VALUES (:email, :workspace_name, :description)";
   
   echo "addWorkspace: $email : $workspace_name : $description <br/>";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':password', $workspace_name);
   $statement->bindValue(':first_name', $description);
   $statement->execute();     // if the statement is successfully executed, execute() returns true
   // false otherwise
		
   $statement->closeCursor();
}


function newWorkspace($email, $workspace_name, $description = "")
{
   global $db;
   $query = "SHOW TABLE STATUS LIKE 'workspace'";
   $statement = $db->prepare($query);
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   // fetch() return a row
   $result = $statement->fetch();
   $group_ID = $result['Auto_increment'];

   // insert into friends (name, major, year) values ('someone', 'CS', 4);
   $query = "INSERT INTO groups VALUES (DEFAULT, :email, :workspace_name, :name, :description)";
   
   echo "newWorkspace: $workspace_name : $description <br/>";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':workspace_name', $workspace_name);
   $statement->bindValue(':description', $description);
   $statement->execute();     // if the statement is successfully executed, execute() returns true
   // false otherwise
   $statement->closeCursor();

   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closeCursor();

   if ($email == "") {
      echo "Not enough parameters entered for newGroup query";
   }

   $statement->closeCursor();
}

function updateWorkspace($email, $workspace_name, $description)
{
   global $db;
	
   $query = "UPDATE workspace SET workspace_name=:workspace_name, description=:description WHERE email=:email";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':password', $workspace_name);
   $statement->bindValue(':first_name', $description);
   $statement->execute();
   $statement->closeCursor();
}



function deleteWorkspace($workspace_name)
{
   global $db;
	
   $query = "DELETE FROM workspace WHERE workspace_name=:workspace_name";
   $statement = $db->prepare($query);
   $statement->bindValue(':workspace_name', $workspace_name);
   $statement->execute();
   $statement->closeCursor();
}
?>

