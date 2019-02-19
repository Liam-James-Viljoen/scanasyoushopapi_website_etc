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
    isTheseParametersAvailable(array('username','password','email','phonenumber', 'salt'));

    $_POST['user']['username'] = $_POST['username'];
    $_POST['user']['password'] = $_POST['password'];
    $_POST['user']['email'] = $_POST['email'];
    $_POST['user']['phone_number'] = $_POST['phonenumber'];
    $_POST['user']['salt'] = $_POST['salt'];

    $result = $usersTable->insert($_POST['user']);
    //if the record is created adding success to response
    if($result){
      //record is created means there is no error
      $response['error'] = false;
      //in message we have a success message
      $response['message'] = 'User addedd successfully';
    }else{
      //if record is not added that means there is an error
      $response['error'] = true;
      //and we have the error message
      $response['message'] = 'Some error occurred please try again';
    }
    break;

    //**********************************************************************************************************************************************************************
    case 'selectuser':
      //first check the parameters required for this request are available or not
      isTheseParametersAvailable(array('username'));
      $response['error'] = false;
      $response['message'] = 'Request completed';
      $response['user'] = $usersTable->find('username', $_POST['username']);
}

}else{
  //if it is not api call
  //pushing appropriate values to response array
 $response['error'] = true;
 $response['message'] = 'Invalid API Call';
}
//displaying the response in json structure
echo json_encode($response);

?>
