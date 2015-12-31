<?php

namespace inoui\controllers_admin;
use \lithium\analysis\Logger;
use \inoui\models\Preferences;
use \inoui_users\models\Users;

class InouiController extends \inoui_admin\extensions\action\AdminController {

    public $publicActions = array('install', 'index');

	protected function _init(){
		parent::_init();
		$this->_bind('preferences', Preferences::get());
	}

	public function log($message) {
	    Logger::debug($message);
	}

    public function install() {
        $this->_render['layout'] = 'login';
		$preferences = Preferences::create();



		if ($this->request->data) {
            $user = Users::create();
            $userdata = [
                'email' => $this->request->data['email'],
                'role' => 'admin',
                'password' => $this->request->data['password']
            ];
            print_r($userdata);

            $user->save($userdata);
            unset($this->request->data['email']);
            unset($this->request->data['password']);

    		if ($user->save($userdata)) {
                $preferences->save($this->request->data);
                return $this->redirect(['Dashboard::index', 'library'=>'inoui_admin', 'admin'=>true]);
    		} else {
                $errors = [];
                foreach($user->errors() as $key => $error) {
                    $errors["{$key}"] = $error;
                }
                $preferences->errors($errors);
            }
		}
		return compact('preferences');

	}

    public function index() {

	}

    protected function _bind($name, &$value) {
        $this->_render['data'][$name] = &$value;
    }



}
?>
