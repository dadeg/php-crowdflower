<?php

require("../vendor/autoload.php");

use CrowdFlower\Account;

$apiKey = 'StQNgqJETkBvyvLU-iiK';

$crowd = new CrowdFlower\Account($apiKey);

//find recent jobs

// $jobs = $crowd->getJobs();
// print_r($jobs);
// print_r("\n");


//create a job with basic attributes

// $attributes = Array (
//         "title" => "Test Title",
//         "instructions" => "Here are some instructions."
//       );
// $job = $crowd->createJob($attributes);
// print_r($job);

//create a job with no attributes
// try {
//   $job = $crowd->getJob(521091);
//   //print_r($job);
// } catch (Exception $e) {
//   echo 'Caught exception: ',  $e->getMessage(), "\n";
// }
//copy the job
try {

  $job = $crowd->getJob('543816');
  $job = $job->copy();
  $options = $job->getAttribute('options');
  $options->front_load = true;
  $job->setAttribute('title', 'test title');
  $job->update();
  print_r($job->getId());
  die();
   $attributes = Array (
        Array ("data" => Array('column1' => 'name', 'column2' => 'url')),
        Array ("data" => Array('column1' => 'name2', 'column2' => 'url2'))
      );
   $job->createUnits($attributes);

  print_r($job->getId());

  die();
  $job2 = $basejob->copy();

} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
//update job with some attributes
try {
  $attributes['title'] = "test ittle yeah";
  $attributes['instructions'] = "does this work";
  $attributes['cml'] = "<p>what is this</p><cml:textarea
label='what in the world' class='' instructions='this makes no sense'
default='huh' validates='required'/>";
  $job2 = $crowd->createJob($attributes);
  print_r($job2);

} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
// delete job2
try {
  $response = $job2->delete();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
// pause job
try {
  $response = $job->pause();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
// resume job
try {
  $response = $job->resume();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// cancel job
try {
  $response = $job->cancel();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}
// status job
try {
  $response = $job->status();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// reset all golds for job
try {
  $response = $job->resetGold();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// set gold for job
try {
  $response = $job->setGold(null);
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// set channels for job
try {
  $response = $job->setChannels('on_demand');
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// get channels for job
try {
  $response = $job->getChannels();
  print_r($response);
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$job->delete();


// // get a single job that should return an error
// try {
//   $job = $crowd->getJob('123');
//   print_r($job);
// } catch (Exception $e) {
//   echo 'Caught exception: ',  $e->getMessage(), "\n";
// }

