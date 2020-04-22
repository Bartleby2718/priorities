<?php 

// Prepared statement (or parameterized statement) happens in 2 phases:
//   1. prepare() sends a template to the server, the server analyzes the syntax
//                and initialize the internal structure.
//   2. bind value (if applicable) and execute
//      bindValue() fills in the template (~fill in the blanks).
//                For example, bindValue(':name', $name);
//                the server will locate the missing part signified by a colon
//                (in this example, :name) in the template
//                and replaces it with the actual value from $name.
//                Thus, be sure to match the name; a mismatch is ignored.
//      execute() actually executes the SQL statement


function getAllListsRelevantNoGroup($email, $workspace_name)
{
   global $db;
   $query = "select * from lists NATURAL JOIN workspace_list_connection WHERE workspace_name=:workspace_name AND email=:email";
   $statement = $db->prepare($query);
   $statement->bindValue(':workspace_name', $workspace_name);
   $statement->bindValue(':email', $email);
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   $results = $statement->fetchAll();
	
   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();
	
   return $results;
}

function getAllListsRelevantGroup($group_ID)
{
   global $db;
   $query = "select * from lists NATURAL JOIN group_list_connection WHERE group_ID=:group_ID";
   $statement = $db->prepare($query);
   $statement->bindValue(':group_ID', $group_ID);
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   $results = $statement->fetchAll();
	
   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();
	
   return $results;
}

function shareList($email, $list_ID)
{
   global $db;
   // put list into default workspace
   $query = "INSERT INTO workspace_list_connection VALUES (:email, DEFAULT, :list_ID)";
   
   echo "shared list number $list_ID with $email <br/>";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->execute();     // if the statement is successfully executed, execute() returns true
   // false otherwise
		
   $statement->closeCursor();
}


function getList_by_list_ID($list_ID)
{
   global $db;
	
   $query = "select * from lists where list_ID = :list_ID";
   $statement = $db->prepare($query);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   // fetch() return a row
   $results = $statement->fetch();
	
   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();
	
   return $results;
}


function newList($title, $description, $email = "", $workspace_name = "", $group_ID = "")
{
   global $db;
   $query = "SHOW TABLE STATUS LIKE 'lists'";
   $statement = $db->prepare($query);
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   // fetch() return a row
   $result = $statement->fetch();
   $list_ID = $result['Auto_increment'];

   // insert into friends (name, major, year) values ('someone', 'CS', 4);
   $query = "INSERT INTO lists VALUES (DEFAULT, :description, :title)";
   
   echo "newList: $title : $description <br/>";
   $statement = $db->prepare($query);
   $statement->bindValue(':title', $title);
   $statement->bindValue(':description', $description);
   $statement->execute();     // if the statement is successfully executed, execute() returns true
   // false otherwise
   $statement->closeCursor();

   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closeCursor();

   if ($group_ID == "" && $email == "" && $workspace_name == "") {
      echo "Not enough parameters entered for newList query";
   } else if ($group_ID == "") {
      echo $list_ID;
      echo $email; 
      echo $workspace_name;
      $query = "INSERT INTO workspace_list_connection VALUES (:email, :workspace_name, :list_ID)";
      $statement = $db->prepare($query);
      $statement->bindValue(':email', $email);
      $statement->bindValue(':workspace_name', $workspace_name);
      $statement->bindValue(':list_ID', (int)$list_ID);
      $statement->execute();
   } else {
      $query = "INSERT INTO group_list_connection VALUES (:list_ID, :group_ID)";
      $statement = $db->prepare($query);
      $statement->bindValue(':list_ID', $list_ID);
      $statement->bindValue(':group_ID', $group_ID);
      $statement->execute();
   }

   $statement->closeCursor();
}


function removeList($list_ID, $workspace_name, $email)
{
   global $db;
	
   $query = "DELETE FROM workspace_list_connection WHERE list_ID=:list_ID AND workspace_name=:workspace_name AND email=:email";
   $statement = $db->prepare($query);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->bindValue(':workspace_name', $workspace_name); //temporary
   $statement->bindValue(':email', $email); //temporary
   $statement->execute();

   $query = "select * from lists, workspace_list_connection where list_ID = :list_ID";
   $statement = $db->prepare($query);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   // fetch() return a row
   $results = $statement->fetch();
   if (empty($results)) {
      $query = "DELETE FROM lists WHERE list_ID=:list_ID";
      $statement = $db->prepare($query);
      $statement->bindValue(':list_ID', $list_ID);
      $statement->execute();
   }


   $statement->closeCursor();


}
?>


