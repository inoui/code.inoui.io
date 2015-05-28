<?php
use lithium\core\Libraries;

Libraries::add('li3_behaviors');
Libraries::add('li3_flash_message');
Libraries::add('li3_mailer');

use li3_mailer\net\mail\Delivery;
use li3_mailer\action\Mailer;

Libraries::add('swiftmailer', array( 
    'path' => LITHIUM_LIBRARY_PATH . '/swiftmailer/swiftmailer',
    'bootstrap' => 'lib/swift_required.php'
));

// Libraries::add("Zend", array(
//     "prefix" => "Zend_",
//     'path' => LITHIUM_LIBRARY_PATH . '/Zend/library/Zend',
//     "includePath" => LITHIUM_LIBRARY_PATH . '/Zend/library',
//     "bootstrap" => "Loader/Autoloader.php",
//     "loader" => array("Zend_Loader_Autoloader", "autoload"),
//     "transform" => function($class) { return str_replace("_", "/", $class) . ".php"; }
// ));

require __DIR__ . '/bootstrap/media.php';

use lithium\core\Environment;

Delivery::config(array('default' => array(
    'production' => array('adapter' => 'Swift', 'transport'=>'mail'),
    'development' => array('adapter' => 'Swift','transport'=>'mail'),
)));

?>
