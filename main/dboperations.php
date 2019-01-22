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
  function createuser($username, $password, $email, $phonenumber){
    $stmt=$this->$connection->prepare('INSERT INTO Users (username, password, email, phonenumber) VALUES (?, ?, ?, ?)');
    $stmt->bind_param("ssis", $username, $password, $email, $phonenumber);
    if ($stmt->execute()){
      return true;
      return false;
    }
  }
  function selectuser(){
    $stmt=$this->$connection->prepare('SELECT id, username, password FROM users');
    $stmt->execute();
    $stmt->bind_param($id, $username, $password);

    $users = array();
    while($stmt->fetch()){
      $user = array();
      $user['id'] = id;
      $user['username'] = $username;
      $user['password'] = $password;

      array_push($users, $user);
    }
    return users;
  }
}
?>
