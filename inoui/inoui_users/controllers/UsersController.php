<?php

namespace inoui_users\controllers;

use lithium\core\Libraries;
use \inoui_users\models\Users;
use \inoui\extensions\Utils\Utils;
use \lithium\net\http\Router;
use \lithium\security\Auth;
use \lithium\g11n\Message;
use \li3_flash_message\extensions\storage\FlashMessage;
use \li3_mailer\action\Mailer;

class UsersController extends \inoui\extensions\action\InouiController {

    public $publicActions = array('login', 'logout', 'register', 'forgot', 'newpassword');

    protected function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
    }

	public function index() {
	    $usr = Auth::check('user');
        if (!isset($usr['_id'])) {
            Auth::clear('user');
            return $this->redirect('/');
        }
	    $user = Users::find('first', array(
			'conditions'=> array('_id'=>$usr['_id'])
        ));
	    if ($this->request->data) {
            $user->save($this->request->data);
	    }
        return compact('user', 'account');
	}

    public function register() {
		$user = Users::create();
		if (($this->request->data) && $user->save($this->request->data)) {

            $data = $this->request->data;
            $user->clearpass = $data['password'];
            extract(Message::aliases());
            $subject = $t("Email register subject");
            $data = compact('user', 'subject');
//            Mailer::deliver('register', compact('data')+array('to'=>$user->email, 'subject'=>$subject, 'type'=>'html'));
            Auth::set('user', $user->data());
			$this->redirect(array('Users::welcome'));
		}
		return compact('user');
	}

	public function welcome() { }

    public function login() {
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
				FlashMessage::write(array($t('Veuillez vérifier vos informations de connexion'), 'class'=>'danger')); 
            }
        } 
		return compact('user');        
    }

    public function logout() {
        Auth::clear('user');
        return $this->redirect('/');
    }

    public function forgot() {
        $user = Users::create();   
        extract(Message::aliases());

        if ($this->request->data) {
        	$usr = Users::find('first', array('conditions' => array('email' => $this->request->data['email'])));
        	if(!empty($usr)) {
        	    $usr->approval_code = Utils::unique_string();
                $usr->save(null, array('validate' => false));
                $subject = $t('Votre mot de passe Coprojet');
                $data = compact('usr', 'subject');
                Mailer::deliver('password', compact('data')+array('to'=>$usr->email, 'subject'=>$subject, 'type'=>'html'));
                $message = $t('Vous allez bientôt recevoir un email');
                FlashMessage::write(array($message, array('class'=>'danger')));
                
        	} else {
                FlashMessage::write(array($t('Cet email n\'existe pas'), array('class'=>'danger')));
        	}
        }
		return compact('user');
    }


    public function newpassword() {

        $approval_code = $this->request->id;
        extract(Message::aliases());

        $user = Users::find('first', array('conditions' => array('approval_code' => $approval_code)));
        if (!empty($user)) {

            if (isset($this->request->data['password'])) {
                if ($this->request->data['password'] != $this->request->data['password2']) {
                    FlashMessage::write(array($t("Veuillez vérifier le mot de passe"), 'class'=>'danger'));
                } else {
	
	        	    $user->password = \lithium\security\Password::hash($this->request->data['password']);
	                $user->save(null, array('validate' => false));

                    // $this->request->data['approval_code'] = '';
                    // $this->request->data['password'] = \lithium\security\Password::hash($this->request->data['password']);
                    // $user->save($this->request->data);
                    FlashMessage::write(array($t("Votre mot de passe est changé"), 'class'=>'danger'));
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));                            
                }
            }
            return compact('user', 'approval_code');
        }
        
       FlashMessage::write(array($t("Utilisateur non trouvé"), array('class'=>'error')));

    }

}

?>