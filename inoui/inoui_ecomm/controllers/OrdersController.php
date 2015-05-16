<?php

namespace inoui_ecomm\controllers;
use inoui_ecomm\models\Carts;
use inoui_ecomm\models\Shippings;
use inoui_ecomm\models\Orders;
use inoui_ecomm\extensions\helper\Payment;
use \lithium\storage\Session;
use Zend_Locale;


class OrdersController extends \inoui\extensions\action\InouiController {

	public function index() {
		$conditions = array('order_number' => $this->request->id, 'email' =>$this->request->email);
		$order = Orders::find('first', compact('conditions'));
		if (!$order) return $this->redirect('/');
		$order->getItems();
		if (count($this->request->args)){
			switch ($this->request->args[0]) {
				case 'email':
					$order->sendOrderEmail();
				break;
				case 'print':
					$this->_render['layout'] = 'empty';
					$this->_render['template'] = 'view-order-print';
				break;

			}
		}
		return compact('order');
	}

	// public function invoice() {
	// 	$conditions = array('order_number' => $this->request->id, 'email' =>$this->request->email);
	// 	$order = Orders::find('first', compact('conditions'));
	// 	if (!$order) return $this->redirect('/');
	// 	$order->getItems();
	// 	return compact('order');
	// }
	// 
	// public function mail() {
	// 	$conditions = array('order_number' => $this->request->id, 'email' =>$this->request->email);
	// 	$order = Orders::find('first', compact('conditions'));
	// 	if (!$order) return $this->redirect('/');
	// 	$order->sendOrderEmail();
	// 	return $this->redirect(array('Orders::index', 'id' => $this->request->id, 'email' =>$this->request->email));
	// }
	// 
}

?>