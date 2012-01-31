<?php

class CdPlayerTest extends \PHPUnit_Framework_TestCase
{
    public function testSomething()
    {
        $cdStub = $this->getMockBuilder('KalkbrennerCd')
            ->disableOriginalConstructor()
            ->getMock();

        $cdStub->expects($this->any())
            ->method('getTrackList')
            ->will($this->returnValue(
                array(
                   1 => 'Titel 1',
                   2 => 'Titel 2',
                   3 => 'Titel 3',
                   4 => 'Titel 4',
                )
            )
        );

        $cdPlayer = new CdPlayer($cdStub);

        // ... assertions here
    }

    public function testSomethingElse()
    {
        $cdStub = $this->getCdMock();
        $cdStub->expects($this->any())
            ->method('getSomething')
            ->will($this->returnValueMap(
                array(
                   array('value1', 'return1'),
                   array('value2', 'return2'),
                   array('value3', 'return3'),
                   array('value4', 'return4'),
                )
            )
        );

        $cdPlayer = new CdPlayer($cdStub);

        // ... assertions here
    }

    public function testSomethingIsCalledWithFooBar()
    {
        $cdStub = $this->getCdMock();
        $cdStub->expects($this->once())
            ->method('doSomething')
            ->with(
                $this->greaterThan(50),
                $this->equalTo('foo'),
                $this->stringContains('bar'),
                $this->anything()
            );

        $cdPlayer = new CdPlayer($cdStub);
    }
}
