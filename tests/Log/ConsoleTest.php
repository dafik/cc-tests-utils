<?php
use Dfi\TestUtils\Log\Console;
use Dfi\TestUtils\Log\Line;

/**
 * Created by IntelliJ IDEA.
 * User: z.wieczorek
 * Date: 29.10.15
 * Time: 09:49
 */
class ConsoleTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $logFixtureFile = 'tests/fixtures/log.fixture';
        $logFixtureToString = 'tests/fixtures/log-to-string.fixture';
        $logFixture = file_get_contents($logFixtureFile);

        $consoleLog = Console::parseLog($logFixture);
        static::assertInstanceOf('Dfi\TestUtils\Log\Console', $consoleLog);

        static::assertEquals('00:01:02', $consoleLog->getDuration());
        static::assertEquals('Thu Oct 29 2015 12:17:47 GMT+0100 (CET)', $consoleLog->getRetrieved());
        static::assertEquals('Thu Oct 29 2015 12:16:44 GMT+0100 (CET)', $consoleLog->getStart());

        $toString = (string)$consoleLog;

        static::assertEquals(file_get_contents($logFixtureToString), $toString);


        $lines = $consoleLog->getLines();
        static::assertInternalType('array', $lines);
        static::assertCount(24, $lines);

        $line = current($lines);
        static::assertInstanceOf('Dfi\TestUtils\Log\Line', $line);


        $line = new Line('2015 - 01 - 20 00:00:01', 'debug', 'testMessage');
        $consoleLog->addLine($line);
        $lines = $consoleLog->getLines();
        static::assertCount(25, $lines);

        static::assertEquals($line, $lines[24]);


    }
}
