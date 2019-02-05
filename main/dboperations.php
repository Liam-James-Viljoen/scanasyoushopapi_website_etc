<?php
class DatabaseTable {
	private $pdo;
	private $table;
	private $primaryKey;

	public function __construct($pdo, $table, $primaryKey) {
		$this->pdo = $pdo;
		$this->table = $table;
		$this->primaryKey = $primaryKey;
	}
//************************************************************************************************************************************************************************************************
//************************************************************************************************************************************************************************************************
	public function find($field, $value) {
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value');

		$criteria = [
			'value' => $value
		];
		$stmt->execute($criteria);

		return $stmt->fetchAll(PDO::FETCH_ASSOC); //Fetch association makes sure it only returns data with it's associated column name. Otherwise it also returns data with column number association
	}
//************************************************************************************************************************************************************************************************
//************************************************************************************************************************************************************************************************
	public function findAll() {
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	//************************************************************************************************************************************************************************************************
	//************************************************************************************************************************************************************************************************
		public function delete($id) {
			$stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id');
			$criteria = [
				'id' => $id
			];
			$stmt->execute($criteria);
		}
//************************************************************************************************************************************************************************************************
//************************************************************************************************************************************************************************************************
	public function insert($record) {
		$keys = array_keys($record);
		$values = implode(', ', $keys);
		$valuesWithColon = implode(', :', $keys);
		$query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($record);

	}
//************************************************************************************************************************************************************************************************
//************************************************************************************************************************************************************************************************
	public function save($record) {
		try {
			$this->insert($record);
		}
		catch (\Exception $e) {
			$this->update($record);
		}
	}
//************************************************************************************************************************************************************************************************
//************************************************************************************************************************************************************************************************
	public function update($record) {

		$query = 'UPDATE ' . $this->table . ' SET ';
		$parameters = [];
		foreach ($record as $key => $value) {
					 $parameters[] = $key . ' = :' .$key;
		}
		$query .= implode(', ', $parameters);
		$query .= ' WHERE ' . $this->primaryKey . ' = :primaryKey';
		$record['primaryKey'] = $record[$this->primaryKey];
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($record);
	}
}

/*
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
    $stmt->bind_param("s", $p_username);
    $stmt->execute();
    $stmt->bind_result($user_id, $username, $password);

    $user = array();
    while($stmt->fetch()){
      $user['user_id'] = $user_id;
      $user['username'] = $username;
      $user['password'] = $password;
    }
    return $user;
  }
}
*/
?>
