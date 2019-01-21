<?php
class DBOperations{
  private $connection

  function __construct(){
    require_once direname(__FILE__) . '/dbconnect.php';

    //Creating DB_connection object to connect to database
    $db = new DB_connection();

    //Initializing connection of this class
    //by calling the method connect of DB_connection class
    $this->connection = $db->connect();
  }
  
}
?>
