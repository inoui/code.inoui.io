<?php

namespace inoui_users\models;

use \lithium\util\Validator;
use \lithium\core\Environment;
use \lithium\security\Auth;
use \lithium\g11n\Message;
use \lithium\security\Password;

use \inoui\extensions\utils\Utils;

class Users extends \inoui\extensions\models\Inoui {

	protected $_schema = array(
		'_id'		=>	array('type' => 'id'),
		'email'		=>	array('type' => 'string', 'null' => false),
		'password'	=>	array('type' => 'string', 'null' => false),
		'first_name'=>	array('type' => 'string', 'null' => false),
		'last_name'	=>	array('type' => 'string', 'null' => false),
		'locale' 	=> array('type' => 'string', 'null' => false),
		'role'		=> array('type' => 'string', 'null' => false),
        'active'      => array('type' => 'boolean', 'default' => false),

		'preferences'		=> array('type' => 'array', 'null' => false),
		'profile'		=> array('type' => 'array', 'null' => false),
		'seo'		=> array('type' => 'array', 'null' => false),

		'updated'	=>	array('type' => 'datetime', 'null' => false),
		'created'	=>	array('type' => 'datetime', 'null' => false)
	);

	protected $_meta = array(
		'key' => '_id',
		'locked' => true
	);

    protected $_actsAs = array(
        'Dateable'
	);

    // protected $_actsAs = array(
    //     'Dateable',
    //         'Attachable' => array(
    //             'img_logo' => array(
    //                 'path' => '{:root}/webroot/media/{:model}/{:id}/{:filename}',
    //                 'url' => '/media/{:model}/{:id}/{:filename}'
    //             )
    //         )
    //     );

    private static $_roles = array(
    	'admin' => 'admin',
    	'publisher' => 'publisher',
    	'user' => 'user',
    );

    public static function validationRules(){
        extract(Message::aliases());
        return array(

			'email' => array(
				array('uniqueEmail', 'message' => $t('This email is already taken')),
				array('notEmpty', 'message' => $t('Please enter an email')),
				array('email', 'message' => $t('Please verify your email'))
			),
			'password' => array(
				array('passwordVerification', 'required' => false, 'message' => $t('Passwords are not the same')),
				array('notEmpty', 'required' => false, 'message' => $t('Please enter a password')),

			),
     	);
	}

    public static function roles() {
        return static::$_roles;
    }
    
    public function name($record, $options = array()) {
        return "{$record->first_name} {$record->last_name}";
    }

    public function status($record) {
        return $record->active?'Activé':'Déactivé';
    }
    
    public static function gender() {
        extract(Message::aliases());
        return array(
            'female' => 'M.',
            'male' => 'Mme',
        );
    }
    
    public static function facebook($fbUser) {
        $fbi = $fbUser->id;
        // if ($admin = Auth::check('admin')) {
        //     $user = Users::create(array("id" => $admin['id']), array("exists" => true));
        //     $user->facebook_uid = $fbi;
        //     $success = $user->save(null, array('validate' => false));
        //     return;
        // }

        $user = Users::find('first', array('conditions' => array('facebook_uid' => $fbUser->id)));
        if (empty($user)) {
            $user = Users::find('first', array('conditions' => array('email' => $fbUser->email)));
            if (!empty($user)) {
                $user->facebook_uid = $fbUser->id;
                $user->save();
            }
        }

        if (empty($user)) {
            $fbUser->facebook_uid = $fbUser->id;
            $fbUser->id = null;
            $user = Users::create();
            $infos = $fbUser->location->name;
            $infos = explode(', ', $infos);
            $fbUser->city = $infos[0];
            $fbUser->country = $infos[1];
            $user->save((array)$fbUser, array('validate' => false));
        }
        $user = Users::find('first', array('conditions' => array('facebook_uid' => $fbi)));
        Auth::set('user', $user->data());        
    }

}

Validator::add('changeRole', function($value, $rule, $options) {
	
});

Validator::add('passwordVerification', function($value, $rule, $options) {
	// print_r($options);
	// echo $value;
	// if (empty($options['values']['password2'])) return true;
	if(isset($options['values']['password2'])) return $options['values']['password2'];
	return true;
});

Validator::add('uniqueEmail', function($value, $params, $options) {
    if (empty($value)) return true;
	$user = Users::find('all', array('conditions' => array('email' => $value)));
	// $conflicts = Users::count(array('email' => $value));
	if (count($user)) {
		$user = $user->first();
		if(!empty($user) && (!isset($options['values']['_id']) || $user->_id != $options['values']['_id'])) {
		    return false;
		}
	}
	return true;
});

// Validator::add('uniqueEmail', function($value, $params, $options) {
	//if (empty($value)) return false;
	//$user = Users::find('first', array('conditions' => array('email' => $value)));
	//if(!empty($user) && (!isset($options['values']['id']) || $user->id != $options['values']['id'])) {
// 	    return false;
// 	}
// 	return true;
// });

Users::applyFilter('save', function($self, $params, $chain){

    $record = $params['entity'];

    if(!($record->exists())){
        // $params['data']['approval_code'] = Utils::unique_string();
		$params['data']['locale'] = Environment::get('locale');
		$params['data']['active'] = 1;
    } 

	if((!empty($params['data']['password']))) {
		$params['data']['password']  = Password::hash($params['data']['password']);
        if (isset($params['data']['password2'])) {
            $params['data']['password2'] = Password::check($params['data']['password2'], $params['data']['password']);    
        }
	} else {
		unset($params['data']['password']);
		unset($params['data']['password2']);
	}	
    return $chain->next($self, $params, $chain);
});
?>