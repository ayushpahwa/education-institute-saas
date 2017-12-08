<?php
$app->get('/session', function() {
  $db = new DbHandler();
  $session = $db->getSession();
  $response["id"] = $session['id'];
  $response["email"] = $session['email'];
  $response["name"] = $session['name'];
  echoResponse(200, $session);
});

$app->post('/login', function() use ($app) { 
  require_once 'passwordHash.php';
  $r = json_decode($app->request->getBody());
  verifyRequiredParams(array('roll', 'password'),$r->customer);
  $response = array();
  $db = new DbHandler();
  $password = $r->customer->password;
  $roll = $r->customer->roll;
  $user = $db->getOneRecord("select * from users where phone='$roll' or roll='$roll'");
  $responses['gandu']=$app->request();
  if ($user != NULL) {
    if(passwordHash::check_password($user['password'],$password)){
      $response['status'] = "success";
      $response['message'] = 'Logged in successfully.';
      $response['name'] = $user['name'];
      $response['id'] = $user['id'];
      $response["phone"] = $user['phone'];
      $response["name"] = $user['name'];
      $response["email"] = $user['email'];
      $response["password"] = $user['password'];
      $response["roll"] = $user['roll'];
      $response["url"] = $user['url'];
      $response["gender"] = $user['gender'];
      $response["room"] = $user['room'];
      $response["hostel"] = $user['hostel'];
      $response["year"] = $user['year'];
      $response["branch"] = $user['branch'];
      $response["batch"] = $user['batch'];
      $response["course"] = $user['course'];      
      if (!isset($_SESSION)) {
        session_start();
      }
      $_SESSION['id'] = $user['id'];
      $_SESSION['roll'] = $roll;
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

$app->post('/signUp', function() use ($app) {
  $response = array();
  $r = json_decode($app->request->getBody());
  verifyRequiredParams(array('roll', 'name', 'password','email','phone','url','gender','hostel','room','branch','batch','course'),$r->customer);
  require_once 'passwordHash.php';
  $db = new DbHandler();
  $phone = $r->customer->phone;
  $name = $r->customer->name;
  $email = $r->customer->email;
  $password = $r->customer->password;
  $roll = $r->customer->roll;
  $url = $r->customer->url;
  $gender = $r->customer->gender;
  $hostel = $r->customer->hostel;
  $room = $r->customer->room;
  $year = $r->customer->year;
  $branch = $r->customer->branch;
  $batch = $r->customer->batch;
  $course = $r->customer->course;
  $isUserExists = $db->getOneRecord("select 1 from users where roll='$roll' or phone='$phone'");
  if(!$isUserExists){
    $r->customer->password = passwordHash::hash($password);
    $table_name = "users";
    $column_names = array('roll', 'name', 'password','email','phone','url','gender','hostel','room','branch','batch');
    $result = $db->insertIntoTable($r->customer, $column_names, $table_name);
    if ($result != NULL) {
      $response["status"] = "success";
      $response["message"] = "User account created successfully";
      $response["id"] = $result;
      if (!isset($_SESSION)) {
        session_start();
      }
      $response["roll"] = $roll;

      $_SESSION['roll'] = $roll;
      $_SESSION['phone'] = $phone;
      $_SESSION['name'] = $name;
      $_SESSION['email'] = $email;
      echoResponse(200, $response);
    } else {
      $response["status"] = "error";
      $response["message"] = "Failed to create customer. Please try again";
      echoResponse(201, $response);
    }
  }else{
    $response["status"] = "error";
    $response["message"] = "An user with the provided phone or email exists!";
    echoResponse(201, $response);
  }
});

$app->get('/logout', function() {
  $db = new DbHandler();
  $session = $db->destroySession();
  $response["status"] = "info";
  $response["message"] = "Logged out successfully";
  echoResponse(200, $response);
});

$app->post('/applogin', function() use ($app) {
  require_once 'passwordHash.php';
  $r = json_decode($app->request->getBody());
  verifyRequiredParams(array('email', 'password'),$r->customer);
  $response = array();
  $db = new DbHandler();
  $password = $r->customer->password;
  $email = $r->customer->email;
  $user = $db->getOneRecord("select id,name,password,email from merchants where phone='$email' or email='$email'");
  if ($user != NULL) {
    if(passwordHash::check_password($user['password'],$password)){
      $response['status'] = "success";
      $response['message'] = 'Logged in successfully.';
      $response['name'] = $user['name'];
      $response['id'] = $user['id'];
      $response['email'] = $user['email'];
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

$app->post('/appsignUp', function() use ($app) {
  $response = array();
  $r = json_decode($app->request->getBody());
  verifyRequiredParams(array('roll', 'name', 'password','email','phone','url','gender','hostel','branch','batch'),$r->customer);
  require_once 'passwordHash.php';
  $db = new DbHandler();
  $phone = $r->customer->phone;
  $name = $r->customer->name;
  $email = $r->customer->email;
  $password = $r->customer->password;
  $roll = $r->customer->roll;
  $url = $r->customer->url;
  $gender = $r->customer->gender;
  $hostel = $r->customer->hostel;
  $year = $r->customer->year;
  $branch = $r->customer->branch;
  $batch = $r->customer->batch;
  $isUserExists = $db->getOneRecord("select 1 from merchants where phone='$phone' or roll='$roll'");
  if(!$isUserExists){
    $r->customer->password = passwordHash::hash($password);
    $table_name = "merchants";
    $column_names = array('phone', 'name', 'email', 'password', 'address');
    $result = $db->insertIntoTable($r->customer, $column_names, $table_name);
    if ($result != NULL) {
      $response["status"] = "success";
      $response["message"] = "User account created successfully";
      $response["id"] = $result;

      echoResponse(200, $response);
    } else {
      $response["status"] = "error";
      $response["message"] = "Failed to create customer. Please try again";
      echoResponse(201, $response);
    }
  }else{
    $response["status"] = "error";
    $response["message"] = "An user with the provided phone or email exists!";
    echoResponse(201, $response);
  }
});

?>
