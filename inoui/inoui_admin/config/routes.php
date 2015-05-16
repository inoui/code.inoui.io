<?php
use lithium\core\Environment;
use lithium\net\http\Router;
use lithium\action\Request;
use lithium\core\Libraries;
use lithium\action\Response;

// Set these so I don't have to keep typing them out
$admin = array('library' => 'inoui_admin', 'admin' => true);
$persist = array('library', 'controller', 'admin');

if ($locales = Environment::get('locales')) {
	Router::connect( '/{:locale:' . join('|', array_keys(Environment::get('locales'))) . '}/{:args}',array(),array(
	    'locale' => null,
	    'args' => null,    
	    'continue' => true, 
	    'persist' => array('locale')
	));
}

use lithium\action\Dispatcher;
Dispatcher::config(array('rules' => function($params) {
	$controller = $params['controller'];
	if (isset($params['library']) && $params['library'] == 'inoui_admin') return array();
	return array(
		'admin' => array('controller' => '{:library}\controllers_admin\\'.$controller.'Controller')
	);
}));
Router::connect('/admin', $admin+array('Dashboard::index'), compact('persist'));
Router::connect('/admin/{:controller}/{:action}/id/{:id:[0-9a-f]{24}}.{:type}', $admin, compact('persist'));
Router::connect('/admin/{:controller}/{:action}/id/{:id:[0-9a-f]{24}}/version/{:version}', $admin, compact('persist'));
Router::connect('/admin/{:controller}/{:action}/id/{:id:[0-9a-f]{24}}', $admin, compact('persist'));
Router::connect('/admin/{:controller}/{:action}/{:args}', $admin, compact('persist'));


// Dispatcher::config(array('rules' => function($params) {
// 
// 	if (isset($params['admin']) && isset($params['library']) && $params['library'] != 'inoui_admin') {
// 		// return array('admin' => array('controller' => 'Admin{:controller}'));
// 	}
// 	return array();
// 	// print_r($params);
// 	// die();
// 	// if (isset($params['admin'])) {
// 	// 	return array('special' => array('action' => 'special_{:action}'));
// 	// }
// 	// return array();
// }));

// Router::connect('/admin/{:controller}/{:action}/id/{:id:[0-9a-f]{24}}.{:type}', $admin, compact('persist'));
// Router::connect('/admin/{:controller}/{:action}/id/{:id:[0-9a-f]{24}}/version/{:version}', $admin, compact('persist'));
// Router::connect('/admin/{:controller}/{:action}/id/{:id:[0-9a-f]{24}}', $admin, compact('persist'));
// 
// Router::connect('/admin/{:controller}/{:action}/{:args}', $admin, compact('persist'));
// Router::connect('/admin/{:controller}/{:action}', $admin, compact('persist'));
// Router::connect('/admin/{:controller}', $admin + array('action' => 'index'), compact('persist'));
// Router::connect('/admin', $admin + array('controller' => 'dashboard', 'action' => 'index'), compact('persist'));

?>