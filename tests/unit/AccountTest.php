<?php

require_once('CrowdFlowerTestCase.php');

use CrowdFlower\Account;

class AccountTest extends CrowdFlowerTestCase
{
    /**
     * @vcr account_get_jobs
     */
    public function testGetJobs()
    {
        $account = new Account(API_KEY);
        $jobs = $account->getJobs();

        $this->assertEquals(529791, $jobs[0]->getId());
        $this->assertEquals(529775, $jobs[1]->getId());
    }

    /**
     * @vcr account_get_job
     */
    public function testGetJob()
    {
        $account = new Account(API_KEY);
        $jobId = 529791;
        $job = $account->getJob($jobId);

        $this->assertEquals($jobId, $job->getId());
    }

    /**
     * @vcr account_create_empty_job
     */
    public function testCreateEmptyJob()
    {
        $account = new Account(API_KEY);
        $job = $account->createJob();

        $this->assertEquals(530880, $job->getId());
    }

    /**
     * @vcr account_create_job_with_title
     */
    public function testCreateJobWithTitle()
    {
        $this->markTestIncomplete(
              'Crowdflower is returning a job with a null title'
        );

        $title = "This is my new job";

        $account = new Account(API_KEY);
        $job = $account->createJob(array(
            "title" => $title
        ));

        $this->assertEquals($title, $job->getAttribute('title'));
    }

    public function testCreateJobWithUnits()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }
}
