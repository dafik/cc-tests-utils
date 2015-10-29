<?php
use Dfi\TestUtils\Module\Map;

/**
 * Created by IntelliJ IDEA.
 * User: z.wieczorek
 * Date: 29.10.15
 * Time: 09:50
 */
class MapTest extends PHPUnit_Framework_TestCase
{


    public function  testGenerate()
    {
        define('TEST_HOST', 'tests/fixtures');
        $srcFixture = 'tests/fixtures/settings/debug/modulemap';
        $file = 'tests/fixtures/module-map.json';
        Map::setConfigFile($file);

        if (file_exists($file)) {
            unlink($file);
        }

        static::assertFileNotExists($file, 'module map exist');

        Map::generate();
        static::assertFileExists($file, 'module map not exist');
        static::assertFileEquals($file, $srcFixture, 'files not equal');
    }

    public function  testGet()
    {
        $map = Map::get();

        static::assertInternalType('array', $map);
        static::assertCount(1, $map);
        static::assertArrayHasKey('administrator', $map);
        $admin = $map['administrator'];
        static::assertInstanceOf('Dfi\TestUtils\Module\Module', $admin);


        static::assertCount(1, $admin);
        static::assertArrayHasKey('callrecords', $admin);
        $callrecords = $admin['callrecords'];
        static::assertInstanceOf('Dfi\TestUtils\Module\Controller', $callrecords);

        static::assertCount(1, $callrecords);
        static::assertArrayHasKey('list', $callrecords);
        $list = $callrecords['list'];
        static::assertInstanceOf('Dfi\TestUtils\Module\Action', $list);


    }

    public function  testGetConfig()
    {

        $configJson = file_get_contents('tests/fixtures/module-map.json');
        $configF = json_decode($configJson);

        $config = Map::getConfig();

        static::assertInstanceOf('stdClass', $config);
        static::assertEquals($configF, $config);


    }

    public function  testGetId()
    {

        $id = Map::getId('administrator');
        static::assertEquals(780, $id);

        $id = Map::getId('administrator', 'callrecords');
        static::assertEquals(797, $id);

        $id = Map::getId('administrator', 'callrecords', 'list');
        static::assertEquals(2097, $id);


        $id = Map::getId('');
        static::assertEquals(false, $id);

        $id = Map::getId('', '');
        static::assertEquals(false, $id);

        $id = Map::getId('', '', '');
        static::assertEquals(false, $id);

        $id = Map::getId('false');
        static::assertEquals(false, $id);

        $id = Map::getId('false', 'false');
        static::assertEquals(false, $id);

        $id = Map::getId('false', 'false', 'false');
        static::assertEquals(false, $id);


    }

    public function  testGetModule()
    {

        $module = Map::getModule('administrator');
        static::assertInstanceOf('Dfi\TestUtils\Module\Module', $module);
        static::assertEquals(780, $module->getId());

        $controller = Map::getModule('administrator', 'callrecords');
        static::assertInstanceOf('Dfi\TestUtils\Module\Controller', $controller);
        static::assertEquals(797, $controller->getId());

        $action = Map::getModule('administrator', 'callrecords', 'list');
        static::assertInstanceOf('Dfi\TestUtils\Module\Action', $action);

        static::assertEquals(2097, $action->getId());


    }


}