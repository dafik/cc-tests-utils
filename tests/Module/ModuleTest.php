<?php
use Dfi\TestUtils\Module\Controller;
use Dfi\TestUtils\Module\Module;

/**
 * Created by IntelliJ IDEA.
 * User: z.wieczorek
 * Date: 29.10.15
 * Time: 09:50
 */
class ModuleTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $defModule = json_decode('{
            "id": 780,
            "name": "administrator",
            "module": "administrator",
            "controller": null,
            "action": null,
            "inMenu": true,
            "level": 1
            }');

        $module = new Module($defModule);

        static::assertEquals($defModule->id, $module->getId());
        static::assertEquals($defModule->name, $module->getName());
        static::assertEquals($defModule->module, $module->getModuleName());
        static::assertEquals($defModule->controller, $module->getControllerName());
        static::assertEquals($defModule->action, $module->getActionName());
        static::assertEquals($defModule->inMenu, $module->getInMenu());
        static::assertEquals($defModule->level, $module->getLevel());


        static::assertFalse($module->has('empty'));
        static::assertFalse($module->offsetExists('empty'));

        try {
            $module->offsetGet('empty');
        } catch (ErrorException $e) {
            static::assertEquals('offset not exist', $e->getMessage());
        }

        static::assertCount(0, $module);

        $module->offsetSet('empty', 'empty');
        static::assertCount(1, $module);


        $module->offsetUnset('empty');
        static::assertCount(0, $module);

        try {
            $module->offsetUnset('empty');
        } catch (ErrorException $e) {
            static::assertEquals('offset not exist', $e->getMessage());
        }

        $defController = json_decode('{
            "id": 797,
            "name": "Callrecords",
            "module": "administrator",
            "controller": "Callrecords",
            "action": null,
            "inMenu": true,
            "level": 2
            }');

        $controller = new Controller($defController, $module);

        $module->addController($controller);
        static::assertCount(1, $module);
        try {
            $c = $module->offsetGet('Callrecords');
            static::assertEquals($controller, $c);

        } catch (ErrorException $e) {
            static::assertEquals(null, $e);
        }

    }

}
