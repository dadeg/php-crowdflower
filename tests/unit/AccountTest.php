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
        $account = new Account($this->getRequest());
        // TODO: shouldn't depend on createJob method, change to curl request
        $account->createJob();

        $jobs = $account->getJobs();
        $this->assertInternalType('integer', $jobs[0]->getId());
    }

    /**
     * @vcr account_get_job
     */
    public function testGetJob()
    {
        $account = new Account($this->getRequest());
        // TODO: shouldn't depend on createJob method, change to curl request
        $createdJob = $account->createJob();

        $job = $account->getJob($createdJob->getId());
        $this->assertEquals($createdJob->getId(), $job->getId());
    }

    /**
     * @vcr account_create_empty_job
     */
    public function testCreateEmptyJob()
    {
        $account = new Account($this->getRequest());
        $job = $account->createJob();

        $this->assertInternalType('integer', $job->getId());
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

        $account = new Account($this->getRequest());
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
