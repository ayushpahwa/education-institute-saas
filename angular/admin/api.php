<?php
require '.././libs/Slim/Slim.php';
require_once 'dbHelper.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app = \Slim\Slim::getInstance();
$db = new dbHelper();
 
/**
 * Database Helper Function templates
 */
/*
select(table name, where clause as associative array)
insert(table name, data as associative array, mandatory column names as array)
update(table name, column names as associative array, where clause as associative array, required columns as array)
delete(table name, where clause as array)
*/


// students
$app->get('/students', function() {
  global $db;
  $rows = $db->select("students","id,name,eid,feetype,amount,feediscount,feemonth,phone,father,mother,contact,sub5,class,batch,img,password",array());
  echoResponse(200, $rows);
});

$app->get('/subjects', function() {
  global $db;
  $rows = $db->select("subjects","id,name,shortform",array());
  echoResponse(200, $rows);
});

$app->get('/batches', function() {
  global $db;
  $rows = $db->select("batches","id,name",array());
  echoResponse(200, $rows);
});

$app->get('/batches', function() {
  global $db;
  $rows = $db->select("batches","id,name",array());
  echoResponse(200, $rows);
});

$app->get('/divisions', function() {
  global $db;
  $rows = $db->select("classes","id,name",array());
  echoResponse(200, $rows);
});

$app->get('/teachers', function() {
  global $db;
  $rows = $db->select("teachers","id,name","email","phone",array());
  echoResponse(200, $rows);
});

$app->get('/managers', function() {
  global $db;
  $rows = $db->select("managers","id,name","email","phone",array());
  echoResponse(200, $rows);
});



$app->post('/students', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array('name');
  global $db;
  $rows = $db->insert("students", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Student added successfully.";
  echoResponse(200, $rows);
});

$app->post('/batches', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array('name');
  global $db;
  $rows = $db->insert("batches", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Batch added successfully.";
  echoResponse(200, $rows);
});

$app->put('/enquiries/:id', function($id) use ($app) {
  $data = json_decode($app->request->getBody());
  $condition = array('id'=>$id);
  $mandatory = array();
  global $db;
  $rows = $db->update("enquiries", $data, $condition, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Enquiry information updated successfully.";
  echoResponse(200, $rows);
});

$app->put('/subjects/:id', function($id) use ($app) {
  $data = json_decode($app->request->getBody());
  $condition = array('id'=>$id);
  $mandatory = array();
  global $db;
  $rows = $db->update("subjects", $data, $condition, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "subject information updated successfully.";
  echoResponse(200, $rows);
});


$app->put('/students/:id', function($id) use ($app) {
  $data = json_decode($app->request->getBody());
  $condition = array('id'=>$id);
  $mandatory = array();
  global $db;
  $rows = $db->update("students", $data, $condition, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Student information updated successfully.";
  echoResponse(200, $rows);
});

$app->put('/divisions/:id', function($id) use ($app) {
  $data = json_decode($app->request->getBody());
  $condition = array('id'=>$id);
  $mandatory = array();
  global $db;
  $rows = $db->update("classes", $data, $condition, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Classes information updated successfully.";
  echoResponse(200, $rows);
});


$app->put('/notifications/:id', function($id) use ($app) {
  $data = json_decode($app->request->getBody());
  $condition = array('id'=>$id);
  $mandatory = array();
  global $db;
  $rows = $db->update("notifications", $data, $condition, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Notification updated successfully.";
  echoResponse(200, $rows);
});

$app->put('/batches/:id', function($id) use ($app) {
  $data = json_decode($app->request->getBody());
  $condition = array('id'=>$id);
  $mandatory = array();
  global $db;
  $rows = $db->update("batches", $data, $condition, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Batches updated successfully.";
  echoResponse(200, $rows);
});

$app->put('/teachers/:id', function($id) use ($app) {
  $data = json_decode($app->request->getBody());
  $condition = array('id'=>$id);
  $mandatory = array();
  global $db;
  $rows = $db->update("teachers", $data, $condition, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Teacher updated successfully.";
  echoResponse(200, $rows);
});

$app->put('/managers/:id', function($id) use ($app) {
  $data = json_decode($app->request->getBody());
  $condition = array('id'=>$id);
  $mandatory = array();
  global $db;
  $rows = $db->update("managers", $data, $condition, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Manager updated successfully.";
  echoResponse(200, $rows);
});


$app->delete('/students/:id', function($id) {
  global $db;
  $rows = $db->delete("students", array('id'=>$id));
  if($rows["status"]=="success")
  $rows["message"] = "Student removed successfully.";
  echoResponse(200, $rows);
});

$app->delete('/enquiry/:id', function($id) {
  global $db;
  $rows = $db->delete("students", array('id'=>$id));
  if($rows["status"]=="success")
  $rows["message"] = "Student removed successfully.";
  echoResponse(200, $rows);
});

$app->delete('/batch/:id', function($id) {
  global $db;
  $rows = $db->delete("batches", array('id'=>$id));
  if($rows["status"]=="success")
  $rows["message"] = "Batch removed successfully.";
  echoResponse(200, $rows);
});

$app->delete('/division/:id', function($id) {
  global $db;
  $rows = $db->delete("classes", array('id'=>$id));
  if($rows["status"]=="success")
  $rows["message"] = "class removed successfully.";
  echoResponse(200, $rows);
});

$app->delete('/subject/:id', function($id) {
  global $db;
  $rows = $db->delete("subjects", array('id'=>$id));
  if($rows["status"]=="success")
  $rows["message"] = "subject removed successfully.";
  echoResponse(200, $rows);
});

$app->delete('/notification/:id', function($id) {
  global $db;
  $rows = $db->delete("notifications", array('id'=>$id));
  if($rows["status"]=="success")
  $rows["message"] = "Notification removed successfully.";
  echoResponse(200, $rows);
});



$app->post('/enquiry', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array('name');
  global $db;
  $rows = $db->insert("inquiryfsub", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Enquiry added successfully.";
  echoResponse(200, $rows);
});

$app->post('/batch', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array('name');
  global $db;
  $rows = $db->insert("batches", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "batch added successfully.";
  echoResponse(200, $rows);
});


$app->post('/notification', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array('title');
  global $db;
  $rows = $db->insert("notifications", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Notification added successfully.";
  echoResponse(200, $rows);
});

$app->post('/division', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array('name');
  global $db;
  $rows = $db->insert("classes", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Notification added successfully.";
  echoResponse(200, $rows);
});

$app->post('/teacher', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array('name');
  global $db;
  $rows = $db->insert("teachers", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Teacher added successfully.";
  echoResponse(200, $rows);
});

$app->post('/manager', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array('name');
  global $db;
  $rows = $db->insert("managers", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Manager added successfully.";
  echoResponse(200, $rows);
});



$app->get('/enquiries', function() {
  global $db;
  $rows = $db->select("inquiry","id,name,gender,class,number,message,date,email",array());
  echoResponse(200, $rows);
});
$app->get('/attendance', function() {
  global $db;
  $rows = $db->select2("attendance","attendanceid,batch,date,subject,class,percent",array(), "ORDER BY attendanceid DESC");
  echoResponse(200, $rows);
});

$app->get('/test', function() {
  global $db;
  $rows = $db->select2("test","testid,class,subject,batch,date,name,mm",array(), "ORDER BY testid DESC");
  echoResponse(200, $rows);
});

$app->get('/testdetails/:testid', function($testid) {
  global $db;
  $rows = $db->select("testdetails","id,name,studentid,marks",array('testid' => $testid));
  echoResponse(200, $rows);
});

$app->get('/attendetails/:attendanceid', function($attendanceid) {
  global $db;
  $rows = $db->select("attenda","id,name,studentid,attendance",array('attendanceid' => $attendanceid));
  echoResponse(200, $rows);
});

$app->get('/studetails/:studentemail', function($studentemail) {
  global $db;
  $rows = $db->select("students","id,name,eid,phone,father,mother,contact,class,batch,sub5,amount,feemonth,feediscount,feetype", array('eid' => $studentemail));
  echoResponse(200, $rows);
});

$app->get('/portalID/:studentid', function($studentid) {
  global $db;
  $rows = $db->select("students","attendanceid,attendance", array('studentid' => $studentid));
  echoResponse(200, $rows);
});

$app->get('/portalA/:studentid', function($studentid) {
  global $db;
  $rows = $db->select("attenda","attendanceid,attendance", array('studentid' => $studentid));
  echoResponse(200, $rows);
});

$app->get('/portalT/:studentid', function($studentid) {
  global $db;
  $rows = $db->select("testdetails","name,testid,studentid,marks", array('studentid' => $studentid));
  echoResponse(200, $rows);
});

$app->get('/portalAS/:class', function($class) {
  global $db;
  $rows = $db->select("assignments","id,name,chapter,class,date,slideshare,subject", array('class' => $class));
  echoResponse(200, $rows);
});

$app->get('/portalAD/:studentid', function($studentid) {
  global $db;
  $rows = $db->selectjoin("test","testdetails","testid","testid",  array('studentid' => $studentid));
  echoResponse(200, $rows);
});

$app->get('/portalattendance/:studentid', function($studentid) {
  global $db;
      $rows = $db->selectjoin("attendance","attenda","attendanceid","attendanceid", array('studentid' => $studentid));

  echoResponse(200, $rows);
});

$app->get('/notifications', function() {
  global $db;
    $rows = $db->select("notifications","id,class,batch,title,message,status,date,type",array(status =>"active"));
  echoResponse(200, $rows);
});

$app->get('/studentsBatch/:class/:batch/:subject', function($class, $batch, $subject) {
    global $db;
    $rows = $db->select("students","id,name,eid,phone,class,batch",array('class' => $class."%", 'batch' => $batch, 'sub5' =>'%'.$subject."%"));
    echoResponse(200, $rows);
});


$app->get('/lastid/:class/:batch/:subject', function($class, $batch, $subject) {
  global $db;
  $rows = $db->select2("attendance","attendanceid",array('class' => $class, 'batch' => $batch, 'subject' => $subject), "ORDER BY attendanceid DESC
  LIMIT 1");
  echoResponse(200, $rows);
});

$app->get('/lasttestid/:class/:batch/:subject', function($class, $batch, $subject) {
  global $db;
  $rows = $db->select2("test","testid",array('class' => $class, 'batch' => $batch, 'subject' => $subject), "ORDER BY testid DESC
  LIMIT 1");
  echoResponse(200, $rows);
});


$app->post('/test', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array();
  global $db;
  $rows = $db->insert("test", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "test added successfully.";
  echoResponse(200, $rows);
});

$app->post('/subject', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array();
  global $db;
  $rows = $db->insert("subjects", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "subject added successfully.";
  echoResponse(200, $rows);
});


$app->post('/attendance', function() use ($app) {
    $data = json_decode($app->request->getBody());
    $mandatory = array();
    global $db;
    $rows = $db->insert("attendance", $data, $mandatory);
    if($rows["status"]=="success")
        $rows["message"] = "Student added successfully.";
    echoResponse(200, $rows);
});

$app->post('/testdetails', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array();
  global $db;
  $rows = $db->insert("testdetails", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Student added successfully.";
  echoResponse(200, $rows);
});


$app->post('/attendetails', function() use ($app) {
  $data = json_decode($app->request->getBody());
  $mandatory = array();
  global $db;
  $rows = $db->insert("attenda", $data, $mandatory);
  if($rows["status"]=="success")
  $rows["message"] = "Student added successfully.";
  echoResponse(200, $rows);
});


$app->delete('/students/:id', function($id) {
    global $db;
    $rows = $db->delete("students", array('id'=>$id));
    if($rows["status"]=="success")
        $rows["message"] = "Student removed successfully.";
    echoResponse(200, $rows);
});

function echoResponse($status_code, $response) {
    global $app;
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response,JSON_NUMERIC_CHECK);
}

$app->run();
?>