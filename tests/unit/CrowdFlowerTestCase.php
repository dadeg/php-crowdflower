<?php

abstract class CrowdFlowerTestCase extends \PHPUnit_Framework_TestCase
{
    protected function getFixturePath()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fixtures';
    }

    protected function getMockedRequest($response)
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
