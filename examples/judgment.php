<?php

require("../vendor/autoload.php");

use CrowdFlower\Account;

$apiKey = 'StQNgqJETkBvyvLU-iiK';


/**
 *
 * Instatiate the container that fetches jobs.
 */
$crowd = new CrowdFlower\Account($apiKey);


/**
 *
 * Get the judgments for a job.
 */

// First find the job we are looking for.
$jobId = 123;
$job = $crowd->getJob($jobId);

// Get a particular judgment for a job.
$judgmentId = 789;
$judgment = $job->getJudgment($judgmentId);

// Get all judgments for a job.
$judgments = $job->getJudgments();


// Get judgments for a unit.
$unitId = 456;
$unit = $job->getUnit($unitId);
$judgments = $unit->getJudgments();

// download all judgments for a job
$response = $job->downloadJudgments();

// delete a judgment.
$judgment->delete();

// get a judgment's unit. Returns the Unit that the judgment belongs to.
$unit = $judgment->getUnit();
