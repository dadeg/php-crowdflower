<?php

require("../vendor/autoload.php");

use CrowdFlower\Account;

$apiKey = 'jLByZLxtuyWV9x6g-Msq';


// Missing examples and functionality: upload(), getChannels(), setChannels()


/**
 *
 * Instatiate the container that fetches jobs.
 */
$crowd = new CrowdFlower\Account($apiKey);


/**
 *
 * Fetching Jobs
 */

// requesting a specific job
$jobId = "123";
$job = $crowd->getJob($jobId);

// requesting a list of all jobs. Returns array of 10 most recent jobs.
// use $page to request older jobs on more pages. $page is optional and defaults to 1.
$page = 1;
$jobs = $crowd->getJobs($page);


/**
 *
 * Creating Jobs
 */

// A job can be created blank like so...
$job = $crowd->createJob();

// Let's delete the job so it doesn't clutter the account.
$job->delete();

// Or with attributes like so...
// These three attributes are required if you are not making a blank job.
$attributes['title']        = "test title";
$attributes['instructions'] = "Step 1: do this. Step 2: do that.";
$attributes['cml']          = "<p>Fill this field out.</p><cml:textarea
                      label='Color of Sky' class='' instructions='What is the color?'
                      default='' validates='required'/>";

$job = $crowd->createJob($attributes);

// Let's delete this job too.
$job->delete();


/**
 *
 * Updating Jobs
 */

// Jobs can be updated, but first they must be fetched and you need to change their attributes.
$jobId = 123;
$job = $crowd->getJob($jobId);

// change one of the attributes which can be found in the CrowdFlower API docs.
$job->setAttribute('title', 'new title');

// You can also change attributes by passing an array.
$newAttributes['title'] = 'newer title';
$newAttributes['instructions'] = 'New instructions';

$job->setAttributes($newAttributes);

// After you have set the attributes on the local object, you must send them to CrowdFlower with the update method.
$job->update();



/**
 *
 * Copying Jobs
 */

// Copy a job with all units, just gold units, or no units. $allUnits and $gold are optional and default to false.
// This will copy the job with just the gold units included.
$allUnits = false;
$gold = true;

$newJob = $job->copy($allUnits, $gold);

// delete the copied job to declutter the CrowdFlower account
$newJob->delete();


/**
 *
 * Modifying the status of Jobs
 */

$jobId = 123;
$job = $crowd->getJob($jobId);

// Check the status of the job.
$status = $job->status();

// Pause the job.
$job->pause();

// Resume the job.
$job->resume();

// Cancel the job.
$job->cancel();
