<?php
namespace Dfi\TestUtils\Module;


class Action extends ModuleAbstract
{

    /**
     * @var  Controller
     */
    private $controller;

    public function __construct($definition, $parent)
    {
        parent::__construct($definition);
        $this->controller = $parent;
    }


    /**
     * @return Controller
     */
    public function getController()
    {
        return $this->controller;
    }

}