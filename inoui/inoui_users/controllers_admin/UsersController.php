<?php
namespace inoui_users\controllers_admin;

use \lithium\core\Libraries;
use \lithium\security\Auth;
use \inoui_users\models\Users;
use \lithium\g11n\Message;
use \li3_flash_message\extensions\storage\FlashMessage;

class UsersController extends \inoui_admin\extensions\action\AdminController {

    public $publicActions = array('login', 'logout', 'forgot');

	public function index() {
		$users = Users::all();
		return compact('users');
	}

	public function edit() {
		$users = Users::all();
		$user = Users::first($this->request->id);	
		$this->_render['template'] = 'index';
		
		if ($this->request->data) {
			$user->save($this->request->data);
		}
		return compact('users', 'user');
	}

	public function add() {
	    $users = Users::all();
	    $user = Users::create();
		$this->_render['template'] = 'index';
		if ($this->request->data && $user->save($this->request->data)) {
			// $this->redirect(array('Users::edit', 'id' => $user->_id));
		}
        return compact('users', 'user');
	}

    public function login() {
		$this->_render['layout'] = 'login';
		$user = Users::create();
		if ($this->request->data) {
			$user->set($this->request->data);
			if ($user = Auth::check('user', $this->request)) {
				$role = isset($user['role']) ? $user['role']:'user';
				$config = Libraries::get('inoui_users');
				if (isset($this->request->data['redirect'])) {
					return $this->redirect(array($this->request->data['redirect']));
				} else {
					if(isset($config['redirect']) && isset($config['redirect'][$role])) {
						$redirect = $config['redirect'][$role];
					} else {
						$redirect = '/';
					}
					return $this->redirect($redirect);
				}
			} else {
				extract(Message::aliases());
				FlashMessage::write(array($t('Please check your credentials'), 'class'=>'danger'));
			}
		}
		return compact('user');
    }

    public function logout() {
        Auth::clear('user');
        return $this->redirect('/');
    }
}

?>