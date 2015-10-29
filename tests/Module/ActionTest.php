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
class ActionTest extends PHPUnit_Framework_TestCase
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


        static::assertEquals($defAction->id, $action->getId());
        static::assertEquals($defAction->name, $action->getName());
        static::assertEquals($defAction->module, $action->getModuleName());
        static::assertEquals($defAction->controller, $action->getControllerName());
        static::assertEquals($defAction->action, $action->getActionName());
        static::assertEquals($defAction->inMenu, $action->getInMenu());
        static::assertEquals($defAction->level, $action->getLevel());

    }
}
