<?php

namespace inoui_admin\controllers;
use lithium\core\Libraries;
use \lithium\g11n\Message;
use app\models\Orders;
use app\models\Shops;
use app\models\Users;
use \lithium\security\Auth;
use \li3_flash_message\extensions\storage\FlashMessage;

class DashboardController extends \inoui\extensions\action\InouiController {


    public function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
        $this->_breadcrumbs['Dashboard'] = array('Dashboard::index');
    }

	public function index() {
		
        extract(Message::aliases());
        $title = $t('Admin - Dashboard');
        $this->set(compact('title'));
        return compact('shop_id');
        
	}

	public function shops() {
        $this->_breadcrumbs['Shops'] = array('Dashboard::index');
        
        if (!Auth::check('superadmin')) {
            extract(Message::aliases());
            FlashMessage::write($t('You need to login to access this page.'), array('class'=>'error')); 
            return $this->redirect(array("Users::login", 'library' => 'inoui_admin', 'admin' => true));
        }
        Auth::clear('admin');
        $shops = Shops::all();
        return compact('shops');
	}

	public function setShop() {
                extract(Message::aliases());
        if (!Auth::check('superadmin')) {
            extract(Message::aliases());
            FlashMessage::write($t('You need to login to access this page.'), array('class'=>'error')); 
            return $this->redirect(array("Users::login", 'library' => 'inoui_admin', 'admin' => true));
        }
        $id = $this->request->id;
        $admin = Users::first(array('conditions'=>
            array(
                'shop_id'=>$id, 
                'role' => 'admin'
            )
        ));
        if (count($admin)) {
            Auth::set('admin', $admin->to('array'));
            return $this->redirect(array("Dashboard::index", 'library' => 'inoui_admin', 'admin' => true));            
        } else {
            FlashMessage::write($t('No admin user found.'), array('class'=>'error')); 
            return $this->redirect(array("Dashboard::shops", 'library' => 'inoui_admin', 'admin' => true));   
        }
	}

}

?>