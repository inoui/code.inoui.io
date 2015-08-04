<?php
use inoui\models\Navigation;
use inoui\core\Inoui;
use lithium\core\Libraries;

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

		'pages' => array(
			'title' => 'Pages',
			'url' => array('Pages::index', 'args' => 'pages', 'library'=>'inoui_cms', 'admin'=>true),
			'options' => array('icon'=>'list-ul')
		),
		'blog' => array(
			'title' => 'Blog post',
			'url' => array('Pages::index', 'args' => 'blog-post', 'library'=>'inoui_cms', 'admin'=>true),
			'options' => array('icon'=>'list-ul')
		),

	    'categories' => array(
	        'title' => 'Categories',
	        'url' => array('Categories::index', 'library'=>'inoui_cms', 'admin'=>true),
	        'options' => array('icon'=>'folder')
	    ),

		'media' => array(
			'title' => 'Media',
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
?>