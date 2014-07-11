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


//create judgments for job

 $attributes = Array (
        Array("country" => "USA"),
        Array("country" => "Canada")
      );
try {
  $response = $job->getUnit(0)->createJudgments($attributes);
  print_r($job->getUnit(0)->judgments);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}


// // get judgments for job
try {
  $response = $job->getJudgments();
  print_r($job->judgments);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}


// get judgments for unit
try {
  $response = $job->getUnit(0)->getJudgments();
  print_r($job->getUnit(0)->judgments);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// download all judgments for job
try {
  $response = $job->downloadJudgments();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// update a judgment. Cannot do without a judgment.


// delete a judgment. Cannot do without a judgment.

// get a judgment's unit. Cannot do without a judgment.


