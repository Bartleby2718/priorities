<?php 

// function create_list()
// {
//    global $db;
//    $query = "CREATE TABLE IF NOT EXISTS list (
//              name VARCHAR(30) PRIMARY KEY,
//              major VARCHAR(20),
//              year INT(1) )";
	
//    $statement = $db->prepare($query);
//    $statement->execute();
//    $statement->closeCursor();
// }

// function drop_list()
// {
//    global $db;
//    $query = "DROP TABLE friends";
	
//    $statement = $db->prepare($query);
//    $statement->execute();
//    $statement->closeCursor();
// }

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


function getAllListsRelevant($workspace_name = "", $email, $group = "")
{
   global $db;
   if ($workspace_name != "") {
      $query = "select * from lists WHERE workspace_name=:workspace_name AND email=:email";
      $statement = $db->prepare($query);
      $statement->bindValue(':workspace_name', $workspace_name);
      $statement->bindValue(':email', $email);
      
   }
   $statement->execute();
	
   // fetchAll() returns an array for all of the rows in the result set
   $results = $statement->fetchAll();
	
   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();
	
   return $results;
}


function getList_by_list_ID($list_ID)
{
   global $db;
   echo "hello";
	
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


function newList($title, $description)
{
   global $db;
	
   // insert into friends (name, major, year) values ('someone', 'CS', 4);
   $query = "INSERT INTO lists VALUES (DEFAULT, :title, :description)";
   
   echo "newList: $title : $description <br/>";
   $statement = $db->prepare($query);
   $statement->bindValue(':title', $title);
   $statement->bindValue(':description', $description);
   $statement->execute();     // if the statement is successfully executed, execute() returns true
   // false otherwise
		
   $statement->closeCursor();
}


function updateFriendInfo($name, $major, $year)
{
   global $db;
	
   // update friends set major="EE", year=2 where name="someoneelse"
   $query = "UPDATE friends SET major=:major, year=:year WHERE name=:name";
   $statement = $db->prepare($query);
   $statement->bindValue(':name', $name);
   $statement->bindValue(':major', $major);
   $statement->bindValue(':year', $year);
   $statement->execute();
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


