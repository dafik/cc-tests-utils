<?php
use Dfi\TestUtils\Log\Line;

/**
 * Created by IntelliJ IDEA.
 * User: z.wieczorek
 * Date: 29.10.15
 * Time: 09:49
 */
class LineTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {

        $logFixtureFile = 'tests/fixtures/log-line.fixture';
        $logFixture = file_get_contents($logFixtureFile);

        $logToStringFixtureFile = 'tests/fixtures/log-line-to-string.fixture';
        $logToStringFixture = file_get_contents($logToStringFixtureFile);

        $line = Line::parseLine($logFixture);

        $toString = (string)$line;
        static::assertEquals($logToStringFixture, $toString);


        $line = new Line('2015-01-20 00:00:01', 'debug', 'testMessage');

        $toString = (string)$line;
        static::assertEquals('2015-01-20 00:00:01 debug testMessage', $toString);
    }
}
