<?php
namespace Dfi\TestUtils\Module;


use ArrayAccess;
use Countable;
use ErrorException;

class Module extends ModuleAbstract implements ArrayAccess, Countable
{
    private $controllers = [];

    public function addController(Controller $controller)
    {
        $name = strtolower($controller->getControllerName());
        $this->controllers[$name] = $controller;
    }

    public function has($controllerName)
    {
        return $this->offsetExists($controllerName);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->controllers);
    }

    public function offsetGet($offset)
    {
        $offset = strtolower($offset);

        if (!array_key_exists($offset, $this->controllers)) {
            throw new ErrorException('offset not exist');
        }
        return $this->controllers[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->controllers[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if ($this->has($offset)) {
            unset($this->controllers[$offset]);
        } else {
            throw new ErrorException('offset not exist');
        }
    }

    public function count()
    {
        return count($this->controllers);
    }
}