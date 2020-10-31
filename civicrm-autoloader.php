<?php declare(strict_types=1);

use PHPStan\DependencyInjection\Container;

assert($container instanceof Container);
if ($container === NULL && !($container instanceof Container)) {
    throw new \PHPStan\ShouldNotHappenException('The autoloader did not receive the container.');
}

// @todo read civicrm.root

$civicrmConfig = $container->getParameter('civicrm');
$civicrmRoot = $civicrmConfig['root'];
$include_path = '.' . PATH_SEPARATOR .
                $civicrmRoot . PATH_SEPARATOR .
                $civicrmRoot . DIRECTORY_SEPARATOR . 'packages' . PATH_SEPARATOR .
                get_include_path( );

if ( set_include_path( $include_path ) === false ) {
    throw new \RuntimeException('Could not set the include path');
}

require_once 'CRM/Core/ClassLoader.php';
CRM_Core_ClassLoader::singleton()->register();
