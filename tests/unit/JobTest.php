<?php

require_once('CrowdFlowerTestCase.php');

use CrowdFlower\Job;

class JobTest extends CrowdFlowerTestCase
{
    public function testCreateEmptyJob()
    {
        $createJobJson = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'createJob.json'
        );

        $job = new Job($this->getMockedRequest($createJobJson));

        $this->assertEquals(5091430, $job->create()->getId());
    }

    public function testCreateJobWithTitle()
    {
        $createJobJson = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'createJob.json'
        );

        $attributes = array('title' => 'This is my new job');
        $job = new Job($this->getMockedRequest($createJobJson));

        $this->assertEquals(
            $attributes['title'],
            $job->create($attributes)->getAttribute('title')
        );
    }

    public function testUpdate()
    {
        $updateJson = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'updateJob.json'
        );

        $newTitle = 'New Title';
        $job = new Job(
            $this->getMockedRequest($updateJob),
            5091431,
            array('title' => 'Old Title')
        );

        $job->setAttribute('title', $newTitle);

        $this->assertEquals(
            $newTitle,
            $job->update()->getAttribute('title')
        );
    }

    public function testDeleteSuccess()
    {
        $deleteJobSuccess = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'deleteJobSuccess.json'
        );

        $job = new Job(
            $this->getMockedRequest($deleteJobSuccess),
            5091431,
            array('title' => 'New Title')
        );

        $this->assertTrue($job->delete());
    }

    /**
     * @expectedException        \CrowdFLower\CrowdFlowerException
     * @expectedExceptionMessage We couldn't find what you were looking for.
     */
    public function testDeleteError()
    {
        $deleteJobError = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'deleteJobError.json'
        );

        $job = new Job(
            $this->getMockedRequest($deleteJobError),
            5091431,
            array('title' => 'New Title')
        );

        $job->delete();
    }
}
