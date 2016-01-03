<?php

use inoui\models\Navigation;
use inoui\models\Channels;
use inoui\core\Inoui;
use lithium\core\Libraries;
use lithium\net\http\Router;
use lithium\core\Environment;


// $channels = Channels::find('all');

$navigation = array(
	'admin.website' => array(
		// 'channels' => array(
		// 	'title' => 'Channels',
		// 	'url' => array('Channels::index', 'library'=>'inoui_cms', 'admin'=>true),
		// 	'options' => array('icon'=>'link')
		// ),

		// 'menu' => array(
		// 	'title' => 'Manage Menus',
		// 	'url' => array('Menus::index', 'library'=>'inoui_cms', 'admin'=>true),
		// 	'options' => array('icon'=>'list-ul')
		// ),

		'documents' => array(
			'title' => 'Your documents',
			'url' => array('Documents::index', 'library'=>'inoui_cms', 'admin'=>true),
			'options' => array('icon'=>'list-ul'),
            'children' => Channels::getChannelsNav()
		),

        'channels' => array(
			'title' => 'Your channels',
			'url' => array('Channels::index', 'library'=>'inoui_cms', 'admin'=>true),
			'options' => array('icon'=>'list-ul')
		),




		// 'blog' => array(
		// 	'title' => 'Blog post',
		// 	'url' => array('Documents::index', 'args' => 'blog-post', 'library'=>'inoui_cms', 'admin'=>true),
		// 	'options' => array('icon'=>'list-ul')
		// ),
        //
	    'categories' => array(
	        'title' => 'Categories',
	        'url' => array('Categories::index', 'library'=>'inoui_cms', 'admin'=>true),
	        'options' => array('icon'=>'folder')
	    ),

		'media' => array(
			'title' => 'Media library',
			'url' => array('Media::index', 'args' => 'press', 'library'=>'inoui_cms', 'admin'=>true),
			'options' => array('icon'=>'picture-o')
		)
	)
);

$config = Libraries::get('inoui_cms');
if (isset($config['admin.website'])) {
	$navigation['admin.website'] += $config['admin.website'];
}

Inoui::register('inoui_cms', compact('navigation'));


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
Router::connect('/preview/{:slug}', $cms  + array('Documents::preview'), compact('persist'));
Router::connect('/p/view/{:args}', $cms  + array('Documents::view'), compact('persist'));





$config = Libraries::get('inoui_cms');

if (isset($config['documents.url'])) {
    $r = $config['documents.url'];
} else {
    $r = 'documents';
}


Router::connect('/'.$r.'/{:slug}', $cms  + array('Documents::index'), compact('persist'));
Router::connect('/'.$r.'/{:action}', $cms  + array('controller' => 'Documents'), compact('persist'));
Router::connect('/preview/{:slug}', $cms  + array('Posts::preview'), compact('persist'));
// Router::connect('/posts/{:category}', $cms  + array('Posts::listing'), compact('persist'));
// Router::connect('/posts/{:category}/{:slug}', $cms  + array('Posts::view'), compact('persist'));

Router::connect('/blog/{:slug}', $cms  + array('Blog::view'), compact('persist'));
Router::connect('/blog', $cms  + array('Blog::index'), compact('persist'));



?>
