<?php
use \lithium\net\http\Router;
use inoui\core\Inoui;
Inoui::setUpAdminRoutes('inoui_users');

$users = array('library' => 'inoui_users');
$persist = array('library', 'controller');
Router::connect('/account/{:controller}/{:action}/{:args}', $users  + array('controller' => 'Pages'), compact('persist'));
?>