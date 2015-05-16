<?php

namespace inoui_ecomm\controllers;
use inoui_ecomm\models\Carts;
use inoui_ecomm\models\Shippings;
use inoui_ecomm\models\Orders;
use inoui_ecomm\extensions\helper\Payment;
use \lithium\storage\Session;
use Zend_Locale;


class CheckoutController extends \inoui\extensions\action\InouiController {

	public function index() {
        $orderId = Session::read('orderId');
		if (!empty($orderId)) {
			$order = Orders::find($orderId);
		} else {
			$order = Orders::create();
		}
		$cart = Carts::getCart(true);
		if ($this->request->data) {
			if (isset($this->request->data['same_address']) && $this->request->data['same_address'] == 1) {

				$this->request->data['billing'] = $this->request->data['shipping'];
				$this->request->data['billing']['first_name'] = $this->request->data['first_name'];
				$this->request->data['billing']['last_name'] = $this->request->data['last_name'];
			}
			if ($order->save($this->request->data)) {
				Session::write('orderId', $order->_id);
				return $this->redirect(array('Checkout::shipping'));				
			}
		}
		return compact('cart', 'order');

	}

	public function shipping() {

        $orderId = Session::read('orderId');
		$order = Orders::find($orderId);
		$cart = Carts::getCart(true);
		$shippings = Shippings::getShipping($order);

		if ($this->request->data && $order->save($this->request->data)) {
			$order->fill($cart);
			return $this->redirect(array('Checkout::payment'));
		}
		if (in_array('billing', $this->request->args)) {
			$order->same_address = 0;
		}
		return compact('cart', 'order', 'shippings');
	}


	public function payment() {
        $orderId = Session::read('orderId');
		$order = Orders::find($orderId);
		
		if ($this->request->data && $order->save($this->request->data)) {
            $template = 'paymentForm';
            $this->_render['layout'] = false;
            $data = compact('order');
            return $this->render(compact('template') + compact('data'));
		}
		$order->getItems();
		return compact('cart', 'order');
		
	}

	public function confirm() {
		Session::delete('orderId');
		$conditions = array('order_number' => $this->request->id);
		$order = Orders::find('first', compact('conditions'));
		$order->getItems();
		$cart = Carts::getCart()->close();
		return compact('order');

	}

	public function validate() {

        $this->_render['layout'] = false;
        $control = Payment::control($this->request);
        if (!count($control->order)) {
            return $this->render(array('layout' => false));
        }
        if (count($control->redirect)) {
            $this->redirect($control->redirect);
        }
        return null;
	}


}

?>