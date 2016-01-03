<?php
use lithium\core\Libraries;
use lithium\action\Response;
use lithium\net\http\Media;
use lithium\action\Dispatcher;

$path = Libraries::get('app', 'path');

Media::type('default', null, array(
    'view' => 'lithium\template\View',
    'paths' => array(
        'layout' => array(
			"{:library}/views/layouts/{:layout}.{:type}.php",
			"{$path}/views/layouts/{:layout}.{:type}.php"
		),
        'template' => array(
			"{$path}/views/{:controller}/{:template}.{:type}.php",
			'{:library}/views/{:controller}/{:template}.{:type}.php',
		),
        'element'  => array(
            '{:library}/views/{:controller}/element_{:template}.{:type}.php',
            '{:library}/views/{:controller}/{:template}.{:type}.php',
            '{:library}/views/elements/{:template}.{:type}.php',
            "{$path}/views/{:controller}/element_{:template}.{:type}.php",
            "{$path}/views/{:controller}/{:template}.{:type}.php",
			"{$path}/views/elements/{:template}.{:type}.php"
        )
    )
));


// Media::type('ajax', array('application/xhtml+xml', 'text/html'), array(
//     'view' => 'lithium\template\View',
//     'paths' => array(
//         'template' => array(
//             '{:library}/views/{:controller}/{:template}.ajax.php',
//             '{:library}/views/{:controller}/{:template}.html.php'
//         ),
//         'layout' => '{:library}/views/layouts/default.ajax.php'
//     ),
//     'conditions' => array('ajax' => true)
// ));


Media::type('ajax', array('application/xhtml+xml', 'text/html'), array(
    'view' => 'lithium\template\View',
    // 'layout' => true,
    // 'templates' => true,
    'paths' => array(
        'template' => array(
            "{$path}/views/{:controller}/{:template}.{:type}.php",
            '{:library}/views/{:controller}/{:template}.{:type}.php',
            '{:library}/views/{:controller}/{:template}.html.php',
            "{$path}/views/elements/{:template}.{:type}.php",
            "{$path}/views/elements/{:template}.html.php"
        ),
        'layout' => false,
        // 'element' => '{:library}/views/elements/{:template}.{:type}.php'
    ),
    'conditions' => array('ajax' => true)
));

Dispatcher::applyFilter('_callable', function($self, $params, $chain) {
	list(, $library, $asset) = explode('/', $params['request']->url, 3) + array("", "", "");
	if ($asset && ($path = Media::webroot($library)) && file_exists($file = "{$path}/{$asset}")) {
		return function() use ($file) {
			$info = pathinfo($file);
			$media = Media::type($info['extension']);
			$content = (array) $media['content'];

			return new Response(array(
				'headers' => array('Content-type' => reset($content)),
				'body' => file_get_contents($file)
			));
		};
	}
	return $chain->next($self, $params, $chain);
});

?>
