<?php
class DBOperations{
  private $connection;

  function __construct(){
    require_once dirname(__FILE__) . '/dbconnect.php';

    //Creating DB_connection object to connect to database
    $db = new DB_connection();

    //Initializing connection of this class
    //by calling the method connect of DB_connection class
    $this->connection = $db->connect();
  }

  function createuser($username, $password, $email, $phonenumber){
    $stmt=$this->connection->prepare('INSERT INTO users (username, password, email, phone_number) VALUES (?, ?, ?, ?)');
    $stmt->bind_param("ssss", $username, $password, $email, $phonenumber);
    if ($stmt->execute())
      return true;
    return false;
  }

  function selectuser($p_username){
    $stmt=$this->connection->prepare('SELECT user_id, username, password FROM users where username=?');
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $username, $password);

    $user = array();
    while($stmt->fetch()){
      $user['user_id'] = $user_id;
      $user['username'] = $username;
      $user['password'] = $password;

      array_push($user);
    }
    return $user;
  }
}
?>
