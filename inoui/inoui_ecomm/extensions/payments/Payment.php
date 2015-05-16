<?php

namespace inoui_ecomm\extensions\payments;
use lithium\net\http\Router;
use inoui_ecomm\models\Orders;
use inoui_users\models\Users;
use lithium\core\Environment;

class Payment extends \lithium\core\StaticObject {

    public $order_number;
    public $order;    
    public $status = 0;    
    public $redirect = array();

	public function __construct() {
    }

    public function getStatus() {
        return $status;
    }

    public function setStatus() {
        if (!empty($this->order_number)) {

            $this->order = Orders::first(array('conditions' => array('order_number' => $this->order_number)));
            $usrId = $this->order->user_id;
            // if (!is_null($usrId)) {
            //     $user = Users::first(array('conditions' => array('id' => $usrId)));
            // 	            if ($user) Environment::set(true, array('locale' => $user->locale));
            // }
            $this->order->setStatus($this->status);
            $this->order->save();
        }
    }

    public function control($request) {
        return $this;
    }

    function getForm($order, $request) {
        
    }

}

?>