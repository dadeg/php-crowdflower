<?php

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use CrowdFlower\Account;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    public function testGetJobs()
    {
        $jobsJson = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'jobs.json'
        );

        $account = new Account($this->getMockedRequest($jobsJson));
        $jobs = $account->getJobs();

        $this->assertEquals(12345, $jobs[0]->getId());
        $this->assertEquals(6789, $jobs[1]->getId());
    }

    public function testCreateEmptyJob()
    {
        $createJobJson = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'createJob.json'
        );

        $account = new Account($this->getMockedRequest($createJobJson));
        $job = $account->createJob();

        $this->assertEquals(5091430, $job->getId());
    }

    public function testCreateJobWithTitle()
    {
        $createJobJson = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'createJob.json'
        );
        $title = "This is my new job";

        $account = new Account($this->getMockedRequest($createJobJson));
        $job = $account->createJob(array(
            "title" => $title
        ));

        $this->assertEquals($title, $job->getTitle());
    }

    public function testCreateJobWithUnits()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    private function getFixturePath()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fixtures';

    }

    private function getMockedRequest($response)
    {
        $request = $this->getMockBuilder('CrowdFlower\Request')
                        ->disableOriginalConstructor()
                        ->setMethods(array('send'))
                        ->getMock();

        $request->expects($this->any())
                ->method('send')
                ->will($this->returnValue($response));

        return $request;
    }
}
