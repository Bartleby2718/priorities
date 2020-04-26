<?php
function getAssignedItems($email)
{
    global $db;
    $query = "SELECT * FROM item_assignment_connection AS iac
              NATURAL JOIN item
              WHERE iac.email = :email;";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();
    return $results;
}
