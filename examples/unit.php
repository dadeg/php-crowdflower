<?php

require("../vendor/autoload.php");

use CrowdFlower\Account;

$apiKey = 'StQNgqJETkBvyvLU-iiK';

$crowd = new CrowdFlower\Account($apiKey);

//create a job with no attributes
try {
  $job = $crowd->createJob();
  //print_r($job);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

//create two units for job
 $attributes = Array (
        Array ("data" => Array('column1' => 'name', 'column2' => 'url')),
        Array ("data" => Array('column1' => 'name2', 'column2' => 'url2'))
      );
try {
  $response = $job->createUnits($attributes);
  //print_r($job);
  //print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// get units for job

try {
  $response = $job->getUnits();
  //print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

//update one unit

// try {
//   $job->getUnit(0)->setAttribute("data", Array('column1' => 'name updated', 'column2' => 'url updated'));
//   $job->getUnit(0)->update();
//   print_r($job->getUnit(0));
//   //print_r($response);
// } catch (Exception $e) {
//   echo 'Caught exception: ',  $e->getMessage(), "\n";
// }

// get status of all units
try {
  $response = $job->unitsStatus();
  print_r($response);
  //print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// cancel a unit
try {
  $units = $job->getUnits;
  $response = $units[0]->cancel();
  print_r($response);
  //print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// delete a unit
try {
  $units = $job->getUnits;
  $response = $units[0]->delete();
  print_r($response);
  //print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}


