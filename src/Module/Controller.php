<?php
namespace Dfi\TestUtils\Module;


use ArrayAccess;
use Countable;
use ErrorException;

class Controller extends ModuleAbstract implements ArrayAccess, Countable
{
    private $actions = [];
    /**
     * @var Module
     */
    private $module;

    public function __construct($definition, Module $parent)
    {
        parent::__construct($definition);
        $this->module = $parent;
    }

    public function addAction(Action $action)
    {
        $name = strtolower($action->getActionName());
        $this->actions[$name] = $action;
    }

    /**
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
    }

    public function has($actionName)
    {
        return $this->offsetExists($actionName);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->actions);
    }

    public function offsetGet($offset)
    {

        $offset = strtolower($offset);
        if (!array_key_exists($offset, $this->actions)) {
            throw new ErrorException('offset not exist');
        }
        return $this->actions[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->actions[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if ($this->has($offset)) {
            unset($this->actions[$offset]);
        } else {
            throw new ErrorException('offset not exist');
        }
    }

    public function count()
    {
        return count($this->actions);
    }
}