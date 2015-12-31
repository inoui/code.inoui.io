<?php
use lithium\net\http\Router;
use lithium\core\Environment;
use lithium\storage\Session;
use lithium\action\Dispatcher;
use lithium\action\Response;
use inoui\models\Photos;

$imageSizer = function($request) {
    $contentTypeMappings = array(
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif'
    );
    // Generate file based image of this
    $imageBody = Photos::generate($request->slug,$request->type,$request->crop,$request->width,$request->height);
    return new Response(array(
        'headers' => array('Content-type' => $contentTypeMappings[$request->type]),
        'body' => $imageBody
    ));
};
$imageHandlingOptions = array(
    'handler' => $imageSizer,
    'keys' => array('slug'=>'slug', 'width'=>'width', 'height'=>'height', 'type'=>'type')
);
Router::connect('/media/{:slug:[\w\/-]+}.{:width:[0-9]*}{:crop:[a-z]{1}}{:height:[0-9]*}.{:type}', array(), $imageHandlingOptions);

$inoui = array('library' => 'inoui', 'admin' => true);
$persist = array('library', 'controller', 'admin');

Router::connect('/inoui', $inoui  + array('Inoui::index'), compact('persist'));
Router::connect('/inoui/install', $inoui  + array('Inoui::install'), compact('persist'));

?>
