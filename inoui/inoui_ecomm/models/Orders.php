<?php

namespace inoui_ecomm\models;

use inoui_ecomm\extensions\g11n\Currency;
use inoui_ecomm\models\Products;
use inoui_ecomm\models\Carts;
use Zend_Locale;

use inoui\action\Mailer;
use inoui\models\Preferences;

use \lithium\g11n\Message;
use \lithium\core\Environment;
use \lithium\storage\Session;
use \lithium\util\Set;
use li3_behaviors\data\model\Behaviors;

class Orders extends \inoui\extensions\models\Inoui {


    use Behaviors;
	protected $_actsAs = array('Dateable');

	protected $_status = array(
		'pending' => 'Pending',
		'ready' => 'Ready',
		'shipped' => 'Shipped',
		'cancelled' => 'Cancelled',
		'returned' => 'Returned'
	);

	public static function getStatus() {
        extract(Message::aliases());

        return array(
            'pending' => $t('Pending'),
            'ready' => $t('Ready'),
            'shipped' => $t('Shipped'),
            'cancelled' => $t('Cancelled'),
            'cancelled' => $t('Cancelled'),
            'return' => $t('Returned'),
            'error' => $t('Payment error'),
			'fulfilled' => $t('Fulfilled')
        );

    }



    public static function validationRules(){
        extract(Message::aliases());
        return array(
    		'first_name' => array(
                array('notEmpty', 'message' => $t('Please fill up your first name.'))
    		),
    		'last_name' => array(
                array('notEmpty', 'message' => $t('Please fill up your last name.'))
    		),
    		'email' => array(
                array('notEmpty', 'message' => $t('Please fill up your email.'))
    		),
    		'shipping.address1' => array(
                array('notEmpty', 'message' => $t('Please fill up your address.'))
    		),
    		'shipping.city' => array(
                array('notEmpty', 'message' => $t('Please fill up your city.'))
    		),
    		'shipping.post_code' => array(
                array('notEmpty', 'message' => $t('Please fill up your post code.'))
    		),
    		'shipping.country' => array(
                array('notEmpty', 'message' => $t('Please fill up your country.'))
    		),
    		'toc' => array(
                array('notEmpty', 'required' => false, 'message' => $t('You must accept the terms of services.')),
    		),
    		'shipping_rate' => array(
                array('notEmpty', 'required' => false, 'message' => $t('You must select a shipping method.')),
    		)


        );
    }





	public function fill($entity) {
		$cart = Carts::getCart();
		$entity->order_number	= Orders::getOrderNumber();
		$entity->status			= 'pending';
		$entity->vat_rate		= '20.0';
		$entity->locale			=  Environment::get('locale');
		$entity->items = $cart->items;
		$entity->total = $cart->total(false) + $entity->shipping_rate;
		$entity->save();
	}

    public function setStatus($entity, $status) {
	    $entity->status = $status;
	    switch ($status) {
	       case 'ready':
				$entity->setInventory();
                $entity->sendOrderEmail();
                break;

            // case 3:
            // case 4:
            //      Tickets::removeTickets($entity);
            //      $items = $entity->setItems();
            //      foreach ($items as $key => $item) {
            //          $rate = Rates::first($item->rate_id);
            //          $rate->decrement('sold', $item->quantity);
            //          $success = $rate->save(null, array('validate' => false));
            //      }
            //
            //      break;
	    }
		$entity->save();
    }

    public function setInventory($entity) {
		$order = clone $entity;
		$order->getItems();
		foreach ($order->items as $key => $item) {
		    $product = Products::first($item->product_id);
            if (!empty($product->quantity)) $product->decrement('quantity', $item->quantity);
		    $success = $product->save(null, array('validate' => false));
		}
	}

    public function sendOrderEmail($entity, $template = 'order') {
		$order = clone $entity;
		$order->getItems();
		$data = array('order'=>$order);

		extract(Message::aliases());

		$preferences = Preferences::get();

		$subject = $t('Thank you for your order #{:order_number} on {:siteName}', array('siteName'=>$preferences->site_name, 'order_number'=>$order->order_number));
		$data['subject'] = $subject;
		$receipt = array(
           'from' => array($preferences->email_name => $preferences->email),
           'to' => $order->email,
           // 'bcc' => $preferences->email,
           'subject' => $subject,
           'type' => 'html'
		);
		Mailer::deliver($template, $receipt+compact('data'));
	}

    public function updateInventory($entity) {

		$entity->getItems();
		foreach ($order->items as $key => $item) {
		    $product = Products::first($item->product_id);
		    $product->decrement('quantity', $item->quantity);
		    $success = $product->save(null, array('validate' => false));
		}

    }

    public static function getOrderNumber() {
        return uniqid();
    }

    public function name($entity, $w = null) {
		if (!is_null($w)) {
			return "{$entity->$w->first_name} {$entity->$w->last_name}";
		}
		return "{$entity->first_name} {$entity->last_name}";
    }

	public function statusLabel($entity) {

		$aLabel = array(
            'pending' => 'default',
            'ready' => 'primary',
            'shipped' => 'success',
            'cancelled' => 'warning',
            'return' => 'inverse',
            'error' => 'danger',
			'fulfilled' => 'info'
        );
		return isset($aLabel[$entity->status]) ? $aLabel[$entity->status]:'default';
	}

	public function address($entity, $w = 'billing') {

		$address = !empty($entity->{$w}->company)?$entity->{$w}->company.'<br/>':'';
		$address .= $entity->{$w}->address1.'<br/>';
		$address .= !empty($entity->{$w}->address2)?$entity->{$w}->address2.'<br/>':'';
		$address .= $entity->{$w}->post_code.' '.$entity->{$w}->city.'<br/>';
		$address .= $entity->country($w);
		return $address;
	}

	public function country($entity, $w = 'billing') {
	    $locale = Environment::get('locale');
	    $locale = explode('_', $locale);
        $countries = Zend_Locale::getTranslationList('Territory', $locale[0], 2);
        if (empty($entity->{$w}->country)) return '';
        return $countries[$entity->{$w}->country];
	}

    public function total($entity, $field = 'total') {
		if (isset($entity->$field)) {
			return Currency::format($entity->$field);
		} else {
			return Currency::format($entity->total, $field, $entity->vat_rate());
		}
    }

	public function vat_rate($entity) {
		if (!is_null($entity->vat_rate)) return $entity->vat_rate;
		else return 19.6;
	}

	public function getItems($entity) {
		$ids = Set::extract($entity->data(), '/items/product_id');
		$products = Products::find('all', array('conditions' => array('_id' => $ids)));
		foreach ($entity->items as $key => $item) {
			$item->product = isset($products[(string)$item->product_id])?$products[(string)$item->product_id]:Products::create();
			$item->total = Currency::format($item->price*$item->quantity);
		}
	}

}




Orders::applyFilter('save', function($self, $params, $chain){
   $record = $params['entity'];
	if (isset($record->items)) {
		foreach($record->items as $item) {
			if (isset($item->product)) unset($item->product);
		}
	}
	$orderHistory = false;

    if($record->exists() && isset($params['data']['status']) && $record->status != $params['data']['status']) $orderHistory = true;

 	$result =  $chain->next($self, $params, $chain);
    if (!$record->errors() && $orderHistory) {
		$history = array(
			'status' => $params['data']['status'],
			'message' => isset($params['data']['status_message'])?$params['data']['status_message']:'',
			'date' => date('Y-m-d H:i:s', time())
		);
		Orders::update(
			array('$addToSet' => array('history' => $history)),
		  	array('_id' => $record->_id),
		  	array('atomic' => false)
		);

		if (isset($params['data']['sendmail']) && $params['data']['sendmail'] == 1) {
			$record->sendOrderEmail('order_'.$params['data']['status']);
		}

    }
	return $result;

});


?>
