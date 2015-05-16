<?php

namespace inoui_ecomm\models;

use \inoui\models\Media;
use \lithium\g11n\Message;
use \lithium\core\Environment;

class Discounts extends \inoui\extensions\models\Inoui {


    protected $_actsAs = array('Dateable');


	protected $_discountTypes = array(
		'pending' => 'Pending', 
		'ready' => 'Ready', 
		'shipped' => 'Shipped', 
		'cancelled' => 'Cancelled',
		'returned' => 'Returned'
	);

	public static function getDiscountTypes() {
        extract(Message::aliases());

        return array(
            'subtotal' => $t('Cart'),
            'product' => $t('Cart'),
            'shipping' => $t('Cart'),
            'discount' => $t('Discount') // discount on product, cart or shipping
        );

    }
    
	



	// public function setDiscount($entity, $order) {
	// 
	//         switch ($entity->type_id) {
	//             case 1:
	//                 $order->total -= $order->total_shipping;
	//                 $order->total_shipping = is_null($entity->value)?0:$entity->value;
	//                 $order->setTotal();
	//                 $order->save();
	//             break;
	//             case 2:
	//                 if (!is_null($entity->product_id)) {
	//                     foreach ($order->items as $item) {
	//                         if ($item->inventory_id == $entity->product_id) {
	//                             $item->price = $entity->value;
	//                             $item->promo_id = $entity->id;
	//                             $item->price_total = $item->price * $item->quantity;
	//                             $item->save();
	//                         }
	//                     }
	//                     $order->setTotal();
	//                     $order->save();
	//                 } 
	//             break;
	//             case 3:
	//             break;
	//             case 4:
	//                 $orderItem = OrderItems::create();
	//                 $orderItem->promo_id    = $entity->id;
	//                 $orderItem->inventory_id    = $entity->product_id;                
	//                 $orderItem->order_id    = $order->id;
	//                 $orderItem->quantity    = $entity->quantity;
	//                 $orderItem->price       = $entity->price;
	//                 $orderItem->price_total = $entity->quantity * $entity->price;
	//                 $orderItem->save();
	// 
	//                 $order->setItems();
	//                 $order->setTotal();
	//                 $order->save();
	// 
	//             break;
	// 
	// }
		


}


Discounts::finder('valid', function($self, $params, $chain){
    $defaults = array(
        'conditions' =>array(
            'code' => $params['options']['code']
            // 'status' => 1
		)
    );
    $defaults = array_replace_recursive($params['options'], $defaults);
    $params['options'] = $defaults + $params['options'];
    return $chain->next($self, $params, $chain);
});

?>



