<?php
use Dfi\TestUtils\Module\Action;
use Dfi\TestUtils\Module\Controller;
use Dfi\TestUtils\Module\Module;

/**
 * Created by IntelliJ IDEA.
 * User: z.wieczorek
 * Date: 29.10.15
 * Time: 09:49
 */
class ControllerTest extends PHPUnit_Framework_TestCase
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


        static::assertEquals($defController->id, $controller->getId());
        static::assertEquals($defController->name, $controller->getName());
        static::assertEquals($defController->module, $controller->getModuleName());
        static::assertEquals($defController->controller, $controller->getControllerName());
        static::assertEquals($defController->action, $controller->getActionName());
        static::assertEquals($defController->inMenu, $controller->getInMenu());
        static::assertEquals($defController->level, $controller->getLevel());


        static::assertFalse($controller->has('empty'));
        static::assertFalse($controller->offsetExists('empty'));

        try {
            $controller->offsetGet('empty');
        } catch (ErrorException $e) {
            static::assertEquals('offset not exist', $e->getMessage());
        }

        static::assertCount(0, $controller);

        $controller->offsetSet('empty', 'empty');
        static::assertCount(1, $controller);


        $controller->offsetUnset('empty');
        static::assertCount(0, $controller);

        try {
            $controller->offsetUnset('empty');
        } catch (ErrorException $e) {
            static::assertEquals('offset not exist', $e->getMessage());
        }

        $defAction = json_decode('{
            "id": 2097,
            "name": "List",
            "module": "administrator",
            "controller": "Callrecords",
            "action": "list",
            "inMenu": true,
            "level": 3
            }');

        $action = new Action($defAction, $controller);

        $controller->addAction($action);
        static::assertCount(1, $controller);

        try {
            $c = $controller->offsetGet('list');
            static::assertEquals($action, $c);

        } catch (ErrorException $e) {
            static::assertEquals(null, $e);
        }

    }
}
