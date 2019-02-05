<?php
 require_once '../main/constants.php';
 require_once '../main/dboperations.php';

//Makes database operations object
$usersTable = new DatabaseTable($pdo, 'users', 'user_id');

function isTheseParametersAvailable($params){
//assuming all parameters are available
$available = true;
$missingparams = "";

foreach($params as $param){
  if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
    $available = false;
    $missingparams = $missingparams . ", " . $param;
  }
}

//if parameters are missing
if(!$available){
  $response = array();
  $response['error'] = true;
  $response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';

  //displaying error
  echo json_encode($response);

  //stopping further execution
  die();
 }
}
//an array to display response
$response = array();
//if it is an api call
//that means a get parameter named api call is set in the URL
//and with this parameter we are concluding that it is an api call
if(isset($_GET['apicall'])){
  switch($_GET['apicall']){
    //**********************************************************************************************************************************************************************
    case 'createuser':
    //Need to add code
    break;

    //**********************************************************************************************************************************************************************
    case 'selectuser':
      //first check the parameters required for this request are available or not
      isTheseParametersAvailable(array('username'));
      $response['error'] = false;
      $response['message'] = 'Request completed';
      $this->$usersTable = $accountsTable;
      $response['user'] = $this->usersTable->find('user_id', $_POST['username']);
    break;
}

}else{
  //if it is not api call
  //pushing appropriate values to response array
 $response['error'] = true;
 $response['message'] = 'Invalid API Call';
}
//displaying the response in json structure
echo json_encode($response);

//$this->$usersTable = $accountsTable;
//			$user = $this->usersTable->find(,user_id);
?>
