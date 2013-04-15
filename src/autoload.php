<?php
$vendorDir = dirname(__FILE__);
/*
 * This is the path to the Autoloader.php file
 */
$autoloader = $vendorDir.'/Forms/Autoloader.php';


if (!file_exists($autoloader) || !is_readable($autoloader)) {
    die('The Autoloader component could not be found. Check src/autoload.php file to fix this.');
}

require $autoloader;

use Forms\Autoloader;

$loader = Autoloader::getLoader();

$loader->addNamespaceDirectory('Forms',        $vendorDir.'/Forms');


function __autoload($class)
{
    Autoloader::getLoader()->loadClass($class);
}

return Autoloader::getLoader();
