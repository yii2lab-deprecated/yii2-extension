<?php

namespace yii2lab\extension\common\helpers;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\ServerErrorHttpException;

class ClassHelper {

    public static function getInstanceOfClassName($class, $classname) {
        $class = self::getClassName($class, $classname);
        if(empty($class)) {
            return null;
        }
        if(class_exists($class)) {
            return new $class();
        }
        return null;
    }

    public static function getNamespaceOfClassName($class) {
        $lastSlash = strrpos($class, '\\');
        return substr($class, 0, $lastSlash);
    }
	
	public static function getClassOfClassName($class) {
		$lastPos = strrpos($class, '\\');
		$name = substr($class, $lastPos + 1);
		return $name;
	}
    
    public static function extractNameFromClass($class, $type) {
        $lastPos = strrpos($class, '\\');
        $name = substr($class, $lastPos + 1, 0 - strlen($type));
        return $name;
    }

    /**
     * @param       $definition
     * @param array $params
     * @param null  $interface
     *
     * @return object
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public static function createObject($definition, array $params = [], $interface = null) {
        if(empty($definition)) {
            throw new InvalidConfigException('Empty class config');
        }
        if(class_exists('Yii')) {
            $object = Yii::createObject($definition, $params);
        } else {
            $definition = self::normalizeComponentConfig($definition);
            $object = new $definition['class'];
            self::configure($object, $params);
            self::configure($object, $definition);
        }
        if(!empty($interface)) {
            self::checkInterface($object, $interface);
        }
        return $object;
    }

    /**
     * @param $object
     * @param $interface
     *
     * @throws ServerErrorHttpException
     */
    public static function checkInterface($object, $interface) {
        if(!is_object($object)) {
            throw new ServerErrorHttpException('Object not be object type');
        }
        if(!$object instanceof $interface) {
            throw new ServerErrorHttpException('Object not be instance of "'.$interface.'"');
        }
    }

    public static function configure($object, $properties)
    {
        if(empty($properties)) {
            return $object;
        }
        foreach ($properties as $name => $value) {
            if($name != 'class') {
                $object->{$name} = $value;
            }
        }
        return $object;
    }

    static function getClassName($className, $namespace) {
        if(empty($namespace)) {
            return $className;
        }
        if(! ClassHelper::isClass($className)) {
            $className = $namespace . '\\' . ucfirst($className);
        }
        return $className;
    }

    public static function getNamespace($name) {
        $name = trim($name, '\\');
        $arr = explode('\\', $name);
        array_pop($arr);
        $name = implode('\\', $arr);
        return $name;
    }

    static function normalizeComponentListConfig($config) {
    	if(empty($config)) {
    		return [];
	    }
	    $components = [];
        foreach($config as $id => &$definition) {
            $definition = self::normalizeComponentConfig($definition);
	        if(self::isComponent($id, $definition)) {
		        $components[$id] = $definition;
	        }
        }
        return $components;
    }
    
    static function isComponent($id, $definition) {
    	return PhpHelper::isValidName($id) && array_key_exists('class', $definition);
    }
    
    static function normalizeComponentConfig($config, $class = null) {
        if(empty($config) && empty($class)) {
            return $config;
        }
        if(!empty($class)) {
            $config['class'] = $class;
        }
        if(is_array($config)) {
            return $config;
        }
        if(self::isClass($config)) {
            $config = ['class' => $config];
        }
        return $config;
    }

    static function isClass($name) {
        return is_string($name) && strpos($name, '\\') !== false;
    }



}