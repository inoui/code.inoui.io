<?php

namespace inoui_ecomm\models;

use \inoui\models\Media;
use \inoui_ecomm\models\orders;
use \lithium\g11n\Message;
use \lithium\core\Environment;
use li3_behaviors\data\model\Behaviors;

class Discounts extends \inoui\extensions\models\Inoui {

    use Behaviors;
    protected $_actsAs = array('Dateable');


	protected $_discountTypes = [
        '%' => 'Minus percentage',
        'amount' => 'Minus amount',
        'shipping' => 'Free shipping'
    ];
 //    array(
	// 	'pending' => 'Pending',
	// 	'ready' => 'Ready',
	// 	'shipped' => 'Shipped',
	// 	'cancelled' => 'Cancelled',
	// 	'returned' => 'Returned'
	// );

	public static function getDiscountTypes() {
        return self::$_discountTypes;
    }





	public static function setDiscount($entity, $total) {

	        switch ($entity->type) {
	            case '%':
                    $total = $total * ((100 - $entity->value) / 100);
                    // $cart->discount = $discount;
                    // $order->total_shipping = is_null($entity->value)?0:$entity->value;
                    // $order->setTotal();
                break;
                case 'amount':
                    $total = $total - $entity->value;
                break;

                case 'shipping':

                break;
	            //     $order->total -= $order->total_shipping;
	            //     $order->total_shipping = is_null($entity->value)?0:$entity->value;
	            //     $order->setTotal();
	            //     $order->save();
	            // break;
	            // case 2:
	            //     if (!is_null($entity->product_id)) {
	            //         foreach ($order->items as $item) {
	            //             if ($item->inventory_id == $entity->product_id) {
	            //                 $item->price = $entity->value;
	            //                 $item->promo_id = $entity->id;
	            //                 $item->price_total = $item->price * $item->quantity;
	            //                 $item->save();
	            //             }
	            //         }
	            //         $order->setTotal();
	            //         $order->save();
	            //     }
	            // break;
	            // case 3:
	            // break;
	            // case 4:
	            //     $orderItem = OrderItems::create();
	            //     $orderItem->promo_id    = $entity->id;
	            //     $orderItem->inventory_id    = $entity->product_id;
	            //     $orderItem->order_id    = $order->id;
	            //     $orderItem->quantity    = $entity->quantity;
	            //     $orderItem->price       = $entity->price;
	            //     $orderItem->price_total = $entity->quantity * $entity->price;
	            //     $orderItem->save();

	            //     $order->setItems();
	            //     $order->setTotal();
	            //     $order->save();

	            // break;
        }
        return $total;
	}

    static function valid($code) {
        $conditions = ['code' => $code];
        $discount = Discounts::first(compact('conditions'));
        return $discount;
    }



}


// Discounts::finder('valid', function($self, $params, $chain){
//     $defaults = array(
//         'conditions' =>array(
//             'code' => $params['options']['code']
//             // 'status' => 1
// 		)
//     );
//     $defaults = array_replace_recursive($params['options'], $defaults);
//     $params['options'] = $defaults + $params['options'];
//     return $chain->next($self, $params, $chain);
// });

?>
