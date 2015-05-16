<?php

use \lithium\g11n\Message;
use lithium\action\Dispatcher;
use lithium\net\http\Router;
use lithium\action\Response;
use lithium\security\Auth;
use lithium\core\Environment;
use li3_flash_message\extensions\storage\FlashMessage;

Dispatcher::applyFilter('_call', function($self, $params, $chain) {

    $ctrl = $params['callable'];
    $user = Auth::check('user');

    if ($params['request']->admin || (is_object($ctrl) && !property_exists($ctrl,'publicActions'))) {
        return $chain->next($self, $params, $chain);
    } else {        
        if (in_array($params['params']['action'], $ctrl->publicActions) || ($user || $admin)) {
            return $chain->next($self, $params, $chain);
        } 
    }
    extract(Message::aliases());
    FlashMessage::write($t('You need to login to access this page.'), array('class'=>'error')); 
    $locale = Environment::get('locale');
    return new Response(compact('request') + array('location' => '/users/login'));

});

?>