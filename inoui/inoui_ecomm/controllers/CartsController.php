<?php

namespace inoui_ecomm\controllers;
use inoui_ecomm\models\Carts;
use inoui_ecomm\models\Discounts;
use inoui_ecomm\models\Orders;

class CartsController extends \inoui\extensions\action\InouiController {

	public function index() {
		$cart = Carts::getCart(true);
		
		
		if ($this->request->data && isset($this->request->data['items'])) {
			foreach($this->request->data['items'] as $id => $quantity) {
				if ($quantity == 0) {
					$cart->deleteItem($id);
				} else {
					$cart->updateQuantity($id, $quantity);	
				}
			}
			$cart = Carts::getCart(true);
			
			if (!empty($this->request->data['discount'])) {				
				$discount = Discounts::find('valid', array('code'=>$this->request->data['discount']));
				if (count($discount)) {
					$cart->setDiscount($discount);
				} else {
					$cart->errors('discount', 'This code is not valid');
				}
			}						
		}		
		if (!$cart->exists() || !count($cart->items)) $this->redirect('/');
		return compact('cart');
	}

	public function add() {
		$id			= $this->request->data['_id'];
		$sku		= isset($this->request->data['sku'])?$this->request->data['sku']:null;
		$quantity	= $this->request->data['quantity'];
		$this->_render['template'] = 'cart';
		Carts::add($id, $quantity, $sku);

        // $this->_render['layout'] = false;
        // $this->_render['library'] = 'app';
        // $this->_render['controller'] = 'elements';        
        // $this->_render['template'] = 'cart';

		return;	
	}


	public function remove() {
		
		if(isset($this->request->id)) {
			$id			= $this->request->id;	
			$this->_render['template'] = 'index';
			$this->redirect(array('Carts::index', 'library'=>'inoui_ecomm'));
		} else {
			$id			= $this->request->data['_id'];
			$this->_render['template'] = 'cart';
		}
		
		Carts::getCart()->deleteItem($id);
		// return $this->redirect(array('Carts::index'));
	}

}

?>