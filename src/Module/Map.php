<?php
namespace Dfi\TestUtils\Module;


class Map
{
    private static $configFile = 'module-map.json';
    private static $config;
    private static $map = [];

    public static function generate()
    {
        if (self::shouldGenerate()) {
            self::generateMap();
        }
    }

    /**
     * @return mixed
     */
    public static function getConfig()
    {
        if (!self::$config) {
            self::get();
        }
        return self::$config;
    }


    public static function get()
    {
        if (!self::$map) {
            $configJson = file_get_contents(self::$configFile);
            $config = json_decode($configJson);
            if (!$config) {
                self::generate();
                return self::get();
            }
            self::$config = $config;
            self::parse($config);
        }
        return self::$map;
    }

    private static function parse($config)
    {
        foreach ($config->modules as $mConfig) {

            switch ($mConfig->level) {
                case 0:
                    break;
                case 1:
                    $name = strtolower($mConfig->module);
                    self::$map[$name] = new Module($mConfig);
                    break;
                case 2:
                    /** @var Module $module */
                    $module = self::getModule($mConfig->module);
                    $module->addController(new Controller($mConfig, $module));
                    break;
                case 3:
                    /** @var Controller $controller */
                    $controller = self::getModule($mConfig->module, $mConfig->controller);
                    $controller->addAction(new Action($mConfig, $controller));
                    break;

            }
        }
    }

    /**
     * @param string $module
     * @param string [$controller]
     * @param string [$action]
     * @return string
     */
    public static function getId($module, $controller = null, $action = null)
    {
        $module = self::getModule($module, $controller, $action);
        if ($module) {
            return $module->getId();
        }
        return $module;
    }

    /**
     * @param string $module
     * @param null|string $controller
     * @param null|string $action
     * @return ModuleAbstract
     */
    public static function getModule($module, $controller = null, $action = null)
    {
        $module = strtolower($module);
        if ($controller) {
            $controller = strtolower($controller);
        }
        if ($action) {
            $action = strtolower($action);
        }

        if ($action !== null) {
            if (array_key_exists($module, self::$map) && self::$map[$module]->has($controller) && self::$map[$module][$controller]->has($action)) {
                return self::$map[$module][$controller][$action];
            }
            return false;
        } elseif ($controller !== null) {
            if (array_key_exists($module, self::$map) && self::$map[$module]->has($controller)) {
                return self::$map[$module][$controller];
            }
            return false;
        } else {
            if (array_key_exists($module, self::$map)) {
                return self::$map[$module];
            }
            return false;

        }
    }

    private static function shouldGenerate()
    {
        if (!file_exists(self::$configFile)) {
            return true;
        }
        $configJson = file_get_contents(self::$configFile);
        $config = json_decode($configJson);
        if (!$config) {
            return true;
        }

        if ($config->host) {
            $host = self::getHost();
            $configHost = $config->host;
            if ($host !== $configHost) {
                return true;
            }
        }
        if ($config->dateGenerate) {
            $date = new \DateTime($config->dateGenerate);
            $date->modify('+1 hour');

            if ($date < date_create()) {
                return true;
            }
        }
        return false;
    }


    private static function generateMap()
    {
        $host = self::getHost();
        $url = $host . '/settings/debug/modulemap';

        $config = file_get_contents($url);

        if ($config) {
            file_put_contents(self::$configFile, $config);
        }

    }

    private static function getHost()
    {
        return TEST_HOST;
    }

    /**
     * @param string $configFile
     */
    public static function setConfigFile($configFile)
    {
        self::$configFile = $configFile;
    }


}