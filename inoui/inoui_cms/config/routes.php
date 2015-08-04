<?php
use lithium\net\http\Router;
use lithium\core\Environment;
use inoui\core\Inoui;
use lithium\core\Libraries;
Inoui::setUpAdminRoutes('inoui_cms');


$cms = array('library' => 'inoui_cms');
$persist = array('library', 'controller');


if ($locales = Environment::get('locales')) {
	if (count($locales) > 1) array_push($persist, 'locale');
	$template = '/{:locale:' . join('|', array_keys($locales)) . '}/{:args}';
	Router::connect($template, array(), array('continue' => true) );
}
// 
// if ($locales = Environment::get('locales')) {
// 	$template = '/{:locale:' . join('|', array_keys($locales)) . '}/{:args}';
// 	Router::connect($template, array(), array('continue' => true));
// }
Router::connect('/preview/{:slug}', $cms  + array('Pages::preview'), compact('persist'));
Router::connect('/p/view/{:args}', $cms  + array('Pages::view'), compact('persist'));





$config = Libraries::get('inoui_cms');

if (isset($config['pages.url'])) {
    $r = $config['pages.url'];
} else {
    $r = 'pages';
}


Router::connect('/'.$r.'/{:slug}', $cms  + array('Pages::index'), compact('persist'));
Router::connect('/'.$r.'/{:action}', $cms  + array('controller' => 'Pages'), compact('persist'));
Router::connect('/preview/{:slug}', $cms  + array('Posts::preview'), compact('persist'));
// Router::connect('/posts/{:category}', $cms  + array('Posts::listing'), compact('persist'));
// Router::connect('/posts/{:category}/{:slug}', $cms  + array('Posts::view'), compact('persist'));

Router::connect('/blog/{:slug}', $cms  + array('Blog::view'), compact('persist'));
Router::connect('/blog', $cms  + array('Blog::index'), compact('persist'));



?>