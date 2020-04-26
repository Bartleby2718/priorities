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
   $query = "SELECT * FROM lists NATURAL JOIN workspace_list_connection
             WHERE workspace_name=:workspace_name AND email=:email
             ORDER BY list_ID;";
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
   $query = "SELECT * FROM lists NATURAL JOIN group_list_connection
             WHERE group_ID=:group_ID ORDER BY list_ID;";
   $statement = $db->prepare($query);
   $statement->bindValue(':group_ID', $group_ID);
   $statement->execute();

   // fetchAll() returns an array for all of the rows in the result set
   $results = $statement->fetchAll();

   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();

   return $results;
}

function getAllGroups($email, $workspace_name)
{
   global $db;
   $query = "SELECT * FROM groups
             WHERE email=:email AND workspace_name=:workspace_name
             ORDER BY group_ID;";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':workspace_name', $workspace_name);
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
   $query = "INSERT INTO workspace_list_connection VALUES (:email, 'primary', :list_ID)";

   echo "shared list number $list_ID with $email <br/>";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->execute();     // if the statement is successfully executed, execute() returns true
   // false otherwise

   $statement->closeCursor();
}

function newGroup($name, $description, $email = "", $workspace_name = "")
{
   global $db;
   $query = "SHOW TABLE STATUS LIKE 'groups'";
   $statement = $db->prepare($query);
   $statement->execute();

   // fetchAll() returns an array for all of the rows in the result set
   // fetch() return a row
   $result = $statement->fetch();
   $group_ID = $result['Auto_increment'];

   // insert into friends (name, major, year) values ('someone', 'CS', 4);
   $query = "INSERT INTO groups VALUES (DEFAULT, :email, :workspace_name, :name, :description)";

   echo "newGroup: $name : $description <br/>";
   $statement = $db->prepare($query);
   $statement->bindValue(':name', $name);
   $statement->bindValue(':description', $description);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':workspace_name', $workspace_name);
   $statement->execute();     // if the statement is successfully executed, execute() returns true
   // false otherwise
   $statement->closeCursor();

   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closeCursor();

   if ($email == "" && $workspace_name == "") {
      echo "Not enough parameters entered for newGroup query";
   }

   $statement->closeCursor();
}

function newListNoGroup($title, $description, $email = "", $workspace_name = "")
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

   if ($email == "" && $workspace_name == "") {
      echo "Not enough parameters entered for newList query";
   } else {
      echo $list_ID;
      echo $email;
      echo $workspace_name;
      $query = "INSERT INTO workspace_list_connection VALUES (:email, :workspace_name, :list_ID)";
      $statement = $db->prepare($query);
      $statement->bindValue(':email', $email);
      $statement->bindValue(':workspace_name', $workspace_name);
      $statement->bindValue(':list_ID', (int) $list_ID);
      $statement->execute();
   }

   $statement->closeCursor();
}

function newListGroup($title, $description, $group_ID = "")
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

   if ($group_ID == "") {
      echo "Not enough parameters entered for newList query";
   } else {
      $query = "INSERT INTO group_list_connection VALUES (:list_ID, :group_ID)";
      $statement = $db->prepare($query);
      $statement->bindValue(':list_ID', $list_ID);
      $statement->bindValue(':group_ID', $group_ID);
      $statement->execute();
   }

   $statement->closeCursor();
}

function removeListWorkspace($list_ID, $workspace_name, $email)
{
   global $db;

   $query = "DELETE FROM workspace_list_connection
             WHERE list_ID=:list_ID
               AND workspace_name=:workspace_name AND email=:email";
   $statement = $db->prepare($query);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->bindValue(':workspace_name', $workspace_name); //temporary
   $statement->bindValue(':email', $email); //temporary
   $statement->execute();

   $query = "SELECT * FROM lists, workspace_list_connection
             WHERE list_ID = :list_ID ORDER BY list_ID;";
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

function removeListGroup($list_ID, $group_ID)
{
   global $db;

   $query = "DELETE FROM group_list_connection
             WHERE list_ID=:list_ID AND group_ID=:group_ID;";
   $statement = $db->prepare($query);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->bindValue(':workspace_name', $group_ID); //temporary
   $statement->execute();

   $query = "SELECT * FROM lists, group_list_connection
             WHERE list_ID = :list_ID ORDER BY list_ID;";
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

function removeGroup($group_ID, $workspace_name, $email)
{
   global $db;

   $query = "DELETE FROM groups WHERE group_ID=:group_ID AND workspace_name=:workspace_name AND email=:email";
   $statement = $db->prepare($query);
   $statement->bindValue(':group_ID', $group_ID);
   $statement->bindValue(':workspace_name', $workspace_name); //temporary
   $statement->bindValue(':email', $email); //temporary
   $statement->execute();

   $statement->closeCursor();
}

function moveListIntoGroup($list_ID, $group_ID, $workspace_name, $email)
{
   global $db;

   $query = "DELETE FROM workspace_list_connection WHERE list_ID=:list_ID AND workspace_name=:workspace_name AND email=:email";
   $statement = $db->prepare($query);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->bindValue(':workspace_name', $workspace_name); //temporary
   $statement->bindValue(':email', $email); //temporary
   $statement->execute();

   $query = "INSERT INTO group_list_connection VALUES (:list_ID, :group_ID)";
   $statement = $db->prepare($query);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->bindValue(':group_ID', $group_ID);
   $statement->execute();

   $statement->closeCursor();
}

function MoveFromGrouptoList($list_ID, $group_ID, $workspace_name, $email)
{
   global $db;

   $query = "DELETE FROM group_list_connection WHERE list_ID=:list_ID AND group_ID=:group_ID";
   $statement = $db->prepare($query);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->bindValue(':group_ID', $group_ID); //temporary
   $statement->execute();

   $query = "INSERT INTO workspace_list_connection VALUES (:email, :workspace_name, :list_ID)";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':workspace_name', $workspace_name);
   $statement->bindValue(':list_ID', (int) $list_ID);
   $statement->execute();

   $statement->closeCursor();
}

function getUserEmails($list_ID)
{
   global $db;

   $query = "SELECT email FROM users
             WHERE email NOT IN(
                SELECT DISTINCT email FROM workspace_list_connection
                WHERE list_ID = :list_ID
                )
             ORDER BY email;";
   $statement = $db->prepare($query);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->execute();

   // fetchAll() returns an array for all of the rows in the result set
   $results = $statement->fetchAll();

   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();

   return $results;
}

function getAllOtherWorkspaces($email, $workspace_name)
{
   global $db;

   $query = "SELECT * FROM workspace
             WHERE email= :email AND workspace_name != :workspace_name
             ORDER BY workspace_name;";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':workspace_name', $workspace_name);
   $statement->execute();

   // fetchAll() returns an array for all of the rows in the result set
   $results = $statement->fetchAll();

   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();

   return $results;
}

function SwitchListWorkspace($email, $old_workspace, $new_workspace, $list_ID)
{
   global $db;

   $query = "DELETE FROM workspace_list_connection WHERE list_ID=:list_ID AND email=:email AND workspace_name=:old_workspace";
   $statement = $db->prepare($query);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':old_workspace', $old_workspace);
   $statement->execute();

   $query = "INSERT INTO workspace_list_connection VALUES (:email, :new_workspace, :list_ID)";
   $statement = $db->prepare($query);
   $statement->bindValue(':email', $email);
   $statement->bindValue(':new_workspace', $new_workspace);
   $statement->bindValue(':list_ID', $list_ID);
   $statement->execute();

   // fetchAll() returns an array for all of the rows in the result set
   $results = $statement->fetchAll();

   // closes the cursor and frees the connection to the server so other SQL statements may be issued
   $statement->closecursor();

   return $results;
}
