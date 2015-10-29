<?php
namespace Dfi\TestUtils\Module;


abstract class ModuleAbstract
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $moduleName;
    /**
     * @var string
     */
    protected $controllerName;
    /**
     * @var string
     */
    protected $actionName;
    /**
     * @var boolean
     */
    protected $inMenu;
    /**
     * @var int
     */
    protected $level;

    /**
     * ModuleAbstract constructor.
     * @param $definition
     */
    public function __construct($definition)
    {
        $this->id = $definition->id;
        $this->name = $definition->name;
        $this->moduleName = $definition->module;
        $this->controllerName = $definition->controller;
        $this->actionName = $definition->action;
        $this->inMenu = $definition->inMenu;
        $this->level = $definition->level;
    }

    /**
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @return string
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function getInMenu()
    {
        return $this->inMenu;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}