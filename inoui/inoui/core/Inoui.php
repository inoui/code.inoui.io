<?php
namespace inoui\core;


use lithium\util\String;
use lithium\util\Inflector;
use lithium\net\http\Router;
use lithium\action\Dispatcher;

use inoui\models\Navigation;

class Inoui extends \lithium\core\StaticObject {
	
	protected static $_configurations = array();

	public static function register($library, $config = array()) {
		$defaults = array(
			'navigation' => false,
			'hasAdmin' => true,
			'uri' => String::extract('/\w+_(\w+)/', $library, 1)
		);
		$config += $defaults;		
		if ($config['navigation'] && is_array($config['navigation'])) {
			foreach ($config['navigation'] as $key => $navigation) {
				Navigation::add($key, $navigation);
			}
		}
		static::$_configurations[$library] = $config;
	}

	public static function setUpAdminRoutes($library, $config = array()) {
		$defaults = array(
			'admin_path' => 'admin',
			'params' => array('library' => $library, 'admin' => true),
			'persist' => array('library', 'controller', 'admin'),
		);
		$config = $config + static::$_configurations[$library];		
		$config += $defaults;
		$uri = String::insert('/{:admin_path}/{:uri}', $config);
		$persist = $config['persist'];
		$controller = Inflector::camelize($config['uri']);
		Router::connect($uri, $config['params']+array('controller'=>$controller,'action'=>'index'), compact('persist'));

		Router::connect($uri.'/{:controller}/{:action}/id/{:id:[0-9a-f]{24}}/page:{:page:[0-9]+}/{:args}', $config['params'], compact('persist'));
		Router::connect($uri.'/{:controller}/{:action}/id/{:id:[0-9a-f]{24}}/{:args}', $config['params'], compact('persist'));
		Router::connect($uri.'/{:controller}/{:action}/page:{:page:[0-9]+}/{:args}', $config['params'], compact('persist'));
		Router::connect($uri.'/{:controller}/{:action}/{:args}', $config['params'], compact('persist'));
	}

}
?>