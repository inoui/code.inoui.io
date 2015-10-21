<?php

namespace inoui_ecomm\models;

use inoui_ecomm\extensions\g11n\Currency;
use inoui_ecomm\models\Products;
use inoui_ecomm\models\Discounts;
use inoui\models\Preferences;

use \lithium\g11n\Message;
use \lithium\core\Environment;
use \lithium\storage\Session;
use lithium\action\Request;
use \lithium\util\Set;
use li3_behaviors\data\model\Behaviors;

class Carts extends \inoui\extensions\models\Inoui {

    use Behaviors;
	protected $_actsAs = array('Dateable');

    // public static function validationRules(){
    //     extract(Message::aliases());
    //     return array(
    // 		'toc' => array(
    //             array('notEmpty', 'message' => $t('Please accept TOC.'))
    // 		)
    //     );
    // }


	public function getLocation() {
		$location = Session::read('location');
		if (empty($location)) {
			$request = new Request();
            switch (true) {
                case (in_array($request->env('REMOTE_ADDR'), array('::1', '127.0.0.1'))):
                    $ip = '80.12.88.143';
                    break;
                default:
                    $ip = $request->env('REMOTE_ADDR');
                    break;
            }
            if (function_exists('geoip_record_by_name')) {
            	$location = geoip_record_by_name($ip);
            } else {
            	$location = ['country_name' => 'France'];
            }

			Session::write('location', $location);
		}
		return $location;
	}


    public static function getCart($full = false) {

        $cartId = Session::read('cartId');
		if (empty($cartId)) {
			$cart = Carts::create();
		} else {
			$cart = Carts::find($cartId);
			if ($full) $cart->getItems();
		}
        return $cart;
    }

	public function totalItems($entity) {
		$total = 0;
		if (count($entity->items)) {
			foreach($entity->items as $item) {
				$total += $item->quantity;
			}
		}
		return $total;

	}

	public function total($entity, $format = true) {
		$total = 0;
		if (count($entity->items)) {
			foreach($entity->items as $item) {
				$total += $item->price*$item->quantity;
			}
		}

		if (isset($entity->discount)) {
			$total = Discounts::setDiscount($entity->discount, $total);
		}

        return $format?Currency::format($total):$total;
	}



	public static function percent($num_amount, $num_total) {
		$count1 = $num_amount / $num_total;
		$count2 = $count1 * 100;
		$count = number_format($count2, 0);
		return $count;
	}

	public function getItem($entity, $_id, $sku = null) {
		foreach($entity->items as $item) {
			if ($sku != null) {
				if ($item->product_id == $_id && $item->variation_sku == $sku) return $item;
			} else {
				if ($item->product_id == $_id) return $item;
			}
		}
		return false;
	}

	public function close($entity) {
		$entity->status = 1;
		$entity->save();
		Session::delete('cartId');
	}

	public function getItems($entity) {
		$ids = Set::extract($entity->data(), '/items/product_id');
		$products = Products::find('all', array('conditions' => array('_id' => $ids)));
		foreach ($entity->items as $key => $item) {
			$item->product = $products[(string)$item->product_id];
			$item->total = Currency::format($item->price*$item->quantity);
		}
	}

	public function deleteItem($entity, $id) {
		Carts::update(
			array('$pull'=>array('items'=>array('product_id'=>$id))),
		  	array('_id' => $entity->_id),
		  	array('atomic' => false)
		);
	}

	static function add($_id, $quantity, $sku = null) {

		$product = Products::first($_id);

		$preferences = Preferences::get();

		if ($sku != null) {
			$variant = $product->getVariation($sku);
			$price = $variant->price;
		} else {
			$price = $product->price;
		}


		$item = array(
			'product_id' =>(string)$product->_id,
			'price' =>$price,
			'sku' => $product->sku,
			'variation_sku' => $sku,
			'quantity' =>$quantity
		);
		$cart = self::getCart();

		if (empty($cart->_id)) {
			$cart->save(array('items'=>array($item)));
            Session::write('cartId', $cart->_id);
		} else {

			if ($exist = $cart->getItem($_id, $sku)) {

				$data = array();
				$data['items.$.quantity'] = $exist->quantity+$quantity;

				Carts::update(
					$data,
				  	array(
						'_id' => $cart->_id,
						'items.product_id' => $_id,
						'items.variation_sku' => $sku
					),
				  	array('atomic' => true)
				);
			} else {
				Carts::update(
					array('$push' => array('items' => $item)),
				  	array('_id' => $cart->_id),
				  	array('atomic' => false)
				);

			}

		}

	}

	public function setDiscount($entity, $discount = '') {
		$entity->discount = $discount;

		$entity->save();
	}

	public function updateQuantity($entity, $_id, $quantity) {

		$data = array();
		$data['items.$.quantity'] = $quantity;
		Carts::update(
			$data,
		  	array(
				'_id' => $entity->_id,
				'items.product_id' => $_id
			),
		  	array('atomic' => true)
		);
	}


}
?>
