<?php

namespace Forms;

/**
 *  Autoloader is a simple PSR-0 compliant class autoloader 
 *  It can manages root namespaces associating them with source directories for
 * 
 *  @author Léo Hetsch
 */
class Autoloader {
    /**
     * The "vendor" directory of your application 
     */

    const VENDOR_DIR = '../vendor';

    /**
     *
     * @var Autoloader 
     */
    protected static $instance;

    /**
     *
     * @var array 
     */
    protected $namespaces = array();

    /**
     *
     * @var array 
     */
    protected $prefixes = array();

    /**
     *
     * @var includepath 
     */
    protected $includepath;

    /**
     * Get the instance of Autoloader
     * 
     * @return Autoloader 
     */
    public static function getLoader() {
        if (empty(self::$instance)) {
            self::$instance = new static;
        }
        return self::$instance;
    }

    /**
     * Register a root namespace with its classes directory.
     * 
     * @param string $namespace
     * @param string $directory 
     */
    public function addNamespaceDirectory($namespace, $directory) {
        $this->namespaces[$namespace] = $directory;
    }

    
    /**
     * Register a prefix.
     * 
     * @param string $prefix
     * @param string $directory
     */
    public function addPrefixDirectory($prefix, $directory) {
        $this->prefixes[$prefix] = $directory;
    }

    /**
     * Set the default include path for class loading
     * The include path will be used for loading fallback if no file was found for some class
     * 
     * @param string $path
     * @throws \InvalidArgumentException if the speficied path is not a valid directory
     */
    public function setIncludePath($path) {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException("The autoloader include path is not a valid directory path");
        }
        $this->includepath = $path;
    }

    /**
     * Load a class using include path if it has been set, or looks in the current directory otherwise
     * 
     * @param string $className 
     */
    public function loadFallBack($className) {
        if (empty($this->includepath)) {
            include $className . '.php';
        } else {
            include $this->includepath . '/' . $className . '.php';
        }
    }

    /**
     * Load a class
     * This loader is PSR-0 compliant, as this rules will be followed :
     *  - Each root-level namespace is registered in the loader and refers to a directory containing classes
     *  - The subnamespace is similar to the files hierarchy inside the library, looking for a file named with the final class name
     *    with the extension .php
     *  - The final class name can includes prefix separators (e.g "_") to follow the files hierarchy
     *    (example : for My_Class_Name, loader will look in directory My/Class for file "Name".php
     * 
     * @param string $className
     * 
     */
    public function loadClass($className) {
        if (false !== strpos($className, '\\')) {

            $explodedNamespace = explode('\\', $className);
            $namespaceRoot = $explodedNamespace[0];
            $className = $explodedNamespace[count($explodedNamespace) - 1];
            $subNamespace = '';

            for ($i = 1; $i < count($explodedNamespace); $i++) {

                if ($i == count($explodedNamespace) - 1) {

                    if (strpos($explodedNamespace[$i], '_')) {

                        $explodedClassName = explode('_', $explodedNamespace[$i]);
                        foreach ($explodedClassName as $classNameHierarchyElement) {
                            $subNamespace .= '\\' . $classNameHierarchyElement;
                        }
                    } else {
                        $subNamespace .= '\\' . $explodedNamespace[$i];
                    }
                } else {
                    $subNamespace .= '\\' . $explodedNamespace[$i];
                }
            }

            if (array_key_exists($namespaceRoot, $this->namespaces)) {
                $nsDir = $this->namespaces[$namespaceRoot];
                $fullNamespace = $nsDir . '/' . str_replace('\\', '/', $subNamespace);
            } else {
                $fullNamespace = $namespaceRoot . str_replace('\\', '/', $subNamespace);
            }

            if (!file_exists($fullNamespace . '.php')) {
                $this->loadFallBack($className);
                return;
            }
        } else {
            $class = str_replace('_', DIRECTORY_SEPARATOR, $className);
            foreach ($this->prefixes as $prefix => $directory) {
                if (0 !== strpos($class, $prefix)) {
                    continue;
                }

                $fullNamespace = $directory . DIRECTORY_SEPARATOR . $class;
            }
        }
        


        require_once $fullNamespace . '.php';
    }

}
