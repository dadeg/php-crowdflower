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

    public function testUpload()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testCopy()
    {
        $copyJob = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'copyJob.json'
        );

        $job = new Job(
            $this->getMockedRequest($copyJob),
            12345,
            array('title' => 'New Title')
        );

        $jobCopy = $job->copy();

        $this->assertEquals(12345, $job->getId());
        $this->assertEquals(511276, $jobCopy->getId());
    }

    /**
     * @expectedException        \CrowdFLower\CrowdFlowerException
     * @expectedExceptionMessage We couldn't find what you were looking for.
     */
    public function testCopyError()
    {
        $copyJobError = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'copyJobError.json'
        );

        $job = new Job(
            $this->getMockedRequest($copyJobError),
            12345,
            array('title' => 'New Title')
        );

        $jobCopy = $job->copy();
    }

    public function testPause()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    /**
     * @expectedException        \CrowdFLower\CrowdFlowerException
     * @expectedExceptionMessage You can't pause a job that hasn't been launched.
     */
    public function testPauseError()
    {
        $pauseJobError = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'pauseJobError.json'
        );

        $job = new Job(
            $this->getMockedRequest($pauseJobError),
            12345,
            array('title' => 'New Title')
        );

        $job = $job->pause();
    }

    public function testResume()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    /**
     * @expectedException        \CrowdFLower\CrowdFlowerException
     * @expectedExceptionMessage You can only resume jobs that are paused or complete.
     */
    public function testResumeError()
    {
        $resumeJobError = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'resumeJobError.json'
        );

        $job = new Job(
            $this->getMockedRequest($resumeJobError),
            12345,
            array('title' => 'New Title')
        );

        $job = $job->resume();
    }

    public function testCancel()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    /**
     * @expectedException        \CrowdFLower\CrowdFlowerException
     * @expectedExceptionMessage You can't cancel a job that hasn't been launched.
     */
    public function testCancelError()
    {
        $cancelJobError = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'cancelJobError.json'
        );

        $job = new Job(
            $this->getMockedRequest($cancelJobError),
            12345,
            array('title' => 'New Title')
        );

        $job = $job->cancel();
    }

    public function testStatus()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    /**
     * @expectedException        \CrowdFLower\CrowdFlowerException
     * @expectedExceptionMessage We couldn't find what you were looking for.
     */
    public function testStatusError()
    {
        $statusJobError = file_get_contents(
            $this->getFixturePath() . DIRECTORY_SEPARATOR . 'statusJobError.json'
        );

        $job = new Job(
            $this->getMockedRequest($statusJobError),
            12345,
            array('title' => 'New Title')
        );

        $job = $job->status();
    }

    public function testResetGold()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testSetGold()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testGetUnits()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testGetUnit()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testCreateUnit()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testCreateUnits()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testUnitsStatus()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testCreateOrder()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testGetJudgments()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testDownloadJudgments()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testGetId()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testSetId()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testGetChannels()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    public function testSetChannels()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }
}
