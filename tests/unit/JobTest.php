<?php

require_once('CrowdFlowerTestCase.php');

use CrowdFlower\Job;
use CrowdFlower\Request;

class JobTest extends CrowdFlowerTestCase
{
    /**
     * @vcr job_create_empty_job
     */
    public function testCreateEmptyJob()
    {
        $job = new Job($this->getRequest());

        $this->assertInternalType('integer', $job->create()->getId());
    }

    /**
     * @vcr job_create_job_with_title
     */
    public function testCreateJobWithTitle()
    {
        $this->markTestIncomplete(
              'Crowdflower is returning a job with a null title'
        );

        $attributes = array('title' => 'This is my new job');
        $job = new Job($this->getRequest());

        $this->assertEquals(
            $attributes['title'],
            $job->create($attributes)->getAttribute('title')
        );
    }

    /**
     * @vcr job_update
     */
    public function testUpdate()
    {
        $this->markTestIncomplete(
              'This test is failing because update not working as expected'
        );

        $newTitle = 'This is my new title';

        $job = new Job($this->getRequest(), 530904);
        $job->setAttribute('title', $newTitle);
        $job->update();

        $this->assertEquals($newTitle, $job->getAttribute('title'));
    }

    /**
     * @vcr job_delete_success
     */
    public function testDeleteSuccess()
    {
        $job = new Job($this->getRequest(), 530904);

        $this->assertTrue($job->delete());
    }

    /**
     * @vcr job_delete_error
     * @expectedException        \CrowdFLower\CrowdFlowerException
     * @expectedExceptionMessage We couldn't find what you were looking for.
     */
    public function testDeleteError()
    {
        // invalid job id
        $job = new Job($this->getRequest(), 99999999999);
        $job->delete();
    }

    public function testUpload()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    /**
     * @vcr job_copy
     */
    public function testCopy()
    {
        $jobId = 530904;
        $job = new Job($this->getRequest(), $jobId);

        $jobCopy = $job->copy();

        $this->assertEquals($jobId, $job->getId());
        $this->assertEquals(511276, $jobCopy->getId());
    }

    public function testPause()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    /**
     * @vcr job_pause_error
     * @expectedException        \CrowdFLower\CrowdFlowerException
     * @expectedExceptionMessage You can't pause a job that hasn't been launched.
     */
    public function testPauseError()
    {
        $job = new Job($this->getRequest());
        $job->create();
        $job->pause();
    }

    public function testResume()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    /**
     * @vcr job_resume_error
     * @expectedException        \CrowdFLower\CrowdFlowerException
     * @expectedExceptionMessage You can only resume jobs that are paused or complete.
     */
    public function testResumeError()
    {
        $job = new Job($this->getRequest());
        $job->create();
        $job->resume();
    }

    public function testCancel()
    {
        $this->markTestIncomplete(
              'This test has not been implemented yet.'
        );
    }

    /**
     * @vcr job_cancel_error
     * @expectedException        \CrowdFLower\CrowdFlowerException
     * @expectedExceptionMessage You can't cancel a job that hasn't been launched.
     */
    public function testCancelError()
    {
        $job = new Job($this->getRequest());
        $job->create();
        $job->cancel();
    }

    /**
     * @vcr job_status
     */
    public function testStatus()
    {
        $job = new Job($this->getRequest());
        $job->create();
        $status = $job->status();
        $this->assertEquals(0, $status->all_units);
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

    /**
     * @vcr job_create_unit
     */
    public function testCreateUnit()
    {
        $job = new Job($this->getRequest());
        $job->create();

        $unit = $job->createUnit(array('data' => array('column1' => 'name2')));

        //$this->assertInternalType('integer', $unit->getId());
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

    private function getRequest()
    {
        return new Request(API_KEY, 'https://api.crowdflower.com/v1/');
    }
}
