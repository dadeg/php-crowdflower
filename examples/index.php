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

// $job = $crowd->createJob();
// print_r($job);
