<?php
use lithium\net\http\Router;
use lithium\core\Environment;

use inoui\core\Inoui;
Inoui::setUpAdminRoutes('inoui_ecomm');


$ecomm = array('library' => 'inoui_ecomm');
$persist = array('library', 'controller');


if ($locales = Environment::get('locales')) {
	if (count($locales) > 1) array_push($persist, 'locale');
	$template = '/{:locale:' . join('|', array_keys(Environment::get('locales'))) . '}/{:args}';
	Router::connect($template, array(), array('continue' => true) );
}


Router::connect('/catalog',  $ecomm +array('Catalog::index'), compact('persist') );
Router::connect('/catalog/collection/{:slug}',  $ecomm +array('Catalog::collection'), compact('persist') );
Router::connect('/catalog/{:category}/{:slug}',  $ecomm + array('Catalog::product'), compact('persist') + array('category' => null, 'slug' => null));
Router::connect('/catalog/{:category}',  $ecomm +array('Catalog::index'), compact('persist') );


Router::connect('/shop/orders/{:id}/{:email}/{:args}', $ecomm + array('Orders::index'), compact('persist')+ array('id' => null, 'email' => null));
Router::connect('/shop/{:controller}/{:action}/id/{:id}', $ecomm, compact('persist'));
Router::connect('/shop/{:controller}/{:action}/{:args}', $ecomm, compact('persist'));
Router::connect('/shop/{:controller}/{:action}', $ecomm, compact('persist'));
Router::connect('/shop/{:controller}', $ecomm + array('action' => 'index'), compact('persist'));


?>