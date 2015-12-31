<?php

use lithium\core\Libraries;
use lithium\action\Dispatcher;
use lithium\net\http\Router;
use lithium\action\Response;
use lithium\security\Auth;
use lithium\core\Environment;
use li3_flash_message\extensions\storage\FlashMessage;
use \lithium\g11n\Message;

use inoui_users\models\Users;

Dispatcher::applyFilter('_call', function($self, $params, $chain) {

    $ctrl = $params['callable'];
	$request = $params['request'];

    if(is_object($ctrl) && $params['request']->admin) {

        $access = false;
		if (property_exists($ctrl,'publicActions')) {
			$action = $params['request']->params['action'];

			if (in_array($action, $ctrl->publicActions)) {
				$access = true;
			}
		}

		if ($user = Auth::check('user')) {
			$role = isset($user['role']) ? $user['role']:null;
			$config = Libraries::get('inoui_admin');
			if (in_array($role, $config['roles'])) {
        		$access = true;
			}
		}

        if(!$access){
            extract(Message::aliases());
            FlashMessage::write(array($t('You are not allowed to access this page.'), 'class'=>'error'));
	        Auth::clear('user');
            $locale = Environment::get('locale');
            return new Response(compact('request')  + array('location' => array('Users::login', 'library'=>'inoui_users', 'admin'=>true),'status'=>302));
		}
        Environment::set(true, array('locale' => 'en'));
    }

    return $chain->next($self, $params, $chain);
});

?>
