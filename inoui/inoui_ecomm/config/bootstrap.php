<?php
use lithium\core\Libraries;
use inoui\core\Inoui;

require __DIR__ . '/bootstrap/auth.php';
require __DIR__ . '/bootstrap/access.php';

$navigation = array(
	'admin.ecomm' => array(
	    'dashboard' => array(
	        'title' => 'Dashboard',
	        'url' => array('Dashboard::index', 'library'=>'inoui_admin', 'admin'=>true),
	        'options' => array('icon'=>'home')
	    ),
	    'orders' => array(
	        'title' => 'Orders',
	        'url' => array('Orders::index', 'library'=>'inoui_ecomm', 'admin'=>true),
	        'options' => array('icon'=>'archive')
	    ),
	    'products' => array(
	        'title' => 'Products',
	        'url' => array('Products::index', 'library'=>'inoui_ecomm', 'admin'=>true),
	        'options' => array('icon'=>'tags')
	    ),
	    'discounts' => array(
	        'title' => 'Discounts',
	        'url' => array('Discounts::index', 'library'=>'inoui_ecomm', 'admin'=>true),
	        'options' => array('icon'=>'star-half-empty')
	    ),
	    'shippings' => array(
	        'title' => 'Shippings',
	        'url' => array('Shippings::index', 'library'=>'inoui_ecomm', 'admin'=>true),
	        'options' => array('icon'=>'truck')
	    )
	)
);
Inoui::register('inoui_ecomm', compact('navigation'));
?>