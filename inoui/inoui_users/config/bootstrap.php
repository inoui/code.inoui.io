<?php
use lithium\core\Libraries;
use inoui\core\Inoui;

require __DIR__ . '/bootstrap/auth.php';
require __DIR__ . '/bootstrap/access.php';

// $navigation = array(
// 	'admin.website' => array(
// 		'users' => array(
//         	'title' => 'Users',
//         	'url' => array('Users::index', 'library' => 'inoui_users'),
// 			'role' => 'admin',
//         	'options' => array('icon'=>'home')
//     	)
// 	)
// );
Inoui::register('inoui_users', compact('navigation'));
?>