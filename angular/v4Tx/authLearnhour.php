<?php
$app->get('/session', function() {
  $db = new DbHandler();
  $session = $db->getSession();
  $response["id"] = $session['id'];
  $response["email"] = $session['email'];
  $response["name"] = $session['name'];
  echoResponse(200, $session);
});

$app->post('/loginManager', function() use ($app) { 
  require_once 'passwordHash.php';
  $r = json_decode($app->request->getBody());
  verifyRequiredParams(array('email', 'password'),$r->customer);
  $response = array();
  $db = new DbHandler();
  $password = $r->customer->password;
  $email = $r->customer->email;
  $user = $db->getOneRecord("select * from managers where email = '$email'");
  $responses['gandu']=$app->request();
  if ($user != NULL) {
    if(passwordHash::check_password($user['password'],$password)){
      $response['status'] = "success";
      $response['message'] = 'Logged in successfully.';
      $response['name'] = $user['name'];
      $response['phone'] = $user['phone'];
      $response['insti_id'] = $user['insti_id'];

      if (!isset($_SESSION)) {
        session_start();
      }
      $_SESSION['id'] = $user['id'];
      $_SESSION['email'] = $email;
      $_SESSION['insti_id'] = $user['name'];
      $_SESSION['name'] = $user['name'];

    } else {
      $response['status'] = "error";
      $response['message'] = 'Login failed. Incorrect credentials';
    }
  }else {
    $response['status'] = "error";
    $response['message'] = 'No such user is registered';
  }
  echoResponse(200, $response);
});

$app->post('/loginTeacher', function() use ($app) { 
  require_once 'passwordHash.php';
  $r = json_decode($app->request->getBody());
  verifyRequiredParams(array('email', 'password'),$r->customer);
  $response = array();
  $db = new DbHandler();
  $password = $r->customer->password;
  $email = $r->customer->email;
  $user = $db->getOneRecord("select * from managers where email = '$email'");
  $responses['gandu']=$app->request();
  if ($user != NULL) {
    if(passwordHash::check_password($user['password'],$password)){
      $response['status'] = "success";
      $response['message'] = 'Logged in successfully.';
      $response['name'] = $user['name'];
      $response['phone'] = $user['phone'];
      $response['insti_id'] = $user['insti_id'];

      if (!isset($_SESSION)) {
        session_start();
      }
      $_SESSION['id'] = $user['id'];
      $_SESSION['email'] = $email;
      $_SESSION['insti_id'] = $user['name'];
      $_SESSION['name'] = $user['name'];

    } else {
      $response['status'] = "error";
      $response['message'] = 'Login failed. Incorrect credentials';
    }
  }else {
    $response['status'] = "error";
    $response['message'] = 'No such user is registered';
  }
  echoResponse(200, $response);
});

$app->post('/loginAdmin', function() use ($app) { 
  require_once 'passwordHash.php';
  $r = json_decode($app->request->getBody());
  verifyRequiredParams(array('email', 'password'),$r->customer);
  $response = array();
  $db = new DbHandler();
  $password = $r->customer->password;
  $email = $r->customer->email;
  $user = $db->getOneRecord("select * from managers where email = '$email'");
  $responses['gandu']=$app->request();
  if ($user != NULL) {
    if(passwordHash::check_password($user['password'],$password)){
      $response['status'] = "success";
      $response['message'] = 'Logged in successfully.';
      $response['name'] = $user['name'];
      $response['phone'] = $user['phone'];
      $response['insti_id'] = $user['insti_id'];

      if (!isset($_SESSION)) {
        session_start();
      }
      $_SESSION['id'] = $user['id'];
      $_SESSION['email'] = $email;
      $_SESSION['insti_id'] = $user['name'];
      $_SESSION['name'] = $user['name'];

    } else {
      $response['status'] = "error";
      $response['message'] = 'Login failed. Incorrect credentials';
    }
  }else {
    $response['status'] = "error";
    $response['message'] = 'No such user is registered';
  }
  echoResponse(200, $response);
});



// $app->post('/signUp', function() use ($app) {
//   $response = array();
//   $r = json_decode($app->request->getBody());
//   verifyRequiredParams(array('roll', 'name', 'password','email','phone','url','gender','hostel','room','branch','batch','course'),$r->customer);
//   require_once 'passwordHash.php';
//   $db = new DbHandler();
//   $phone = $r->customer->phone;
//   $name = $r->customer->name;
//   $email = $r->customer->email;
//   $password = $r->customer->password;
//   $roll = $r->customer->roll;
//   $url = $r->customer->url;
//   $gender = $r->customer->gender;
//   $hostel = $r->customer->hostel;
//   $room = $r->customer->room;
//   $year = $r->customer->year;
//   $branch = $r->customer->branch;
//   $batch = $r->customer->batch;
//   $course = $r->customer->course;
//   $isUserExists = $db->getOneRecord("select 1 from users where roll='$roll' or phone='$phone'");
//   if(!$isUserExists){
//     $r->customer->password = passwordHash::hash($password);
//     $table_name = "users";
//     $column_names = array('roll', 'name', 'password','email','phone','url','gender','hostel','room','branch','batch');
//     $result = $db->insertIntoTable($r->customer, $column_names, $table_name);
//     if ($result != NULL) {
//       $response["status"] = "success";
//       $response["message"] = "User account created successfully";
//       $response["id"] = $result;
//       if (!isset($_SESSION)) {
//         session_start();
//       }
//       $response["roll"] = $roll;

//       $_SESSION['roll'] = $roll;
//       $_SESSION['phone'] = $phone;
//       $_SESSION['name'] = $name;
//       $_SESSION['email'] = $email;
//       echoResponse(200, $response);
//     } else {
//       $response["status"] = "error";
//       $response["message"] = "Failed to create customer. Please try again";
//       echoResponse(201, $response);
//     }
//   }else{
//     $response["status"] = "error";
//     $response["message"] = "An user with the provided phone or email exists!";
//     echoResponse(201, $response);
//   }
// });

$app->get('/logout', function() {
  $db = new DbHandler();
  $session = $db->destroySession();
  $response["status"] = "info";
  $response["message"] = "Logged out successfully";
  echoResponse(200, $response);
});

?>
