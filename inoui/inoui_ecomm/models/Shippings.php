<?php

namespace inoui_ecomm\models;

use \inoui\models\Media;
use \lithium\g11n\Message;
use \lithium\core\Environment;
use inoui_ecomm\extensions\g11n\Currency;
use \Zend_Locale;
use li3_behaviors\data\model\Behaviors;

class Shippings extends \inoui\extensions\models\Inoui {

    use Behaviors;
    protected $_actsAs = array('Dateable', 'Slugable');

    public function price($entity) {
		return Currency::format($entity->price);
	}


	public static function getShipping($order = null, $free = false) {
		$regions = Zend_Locale::getTranslationList('TerritoryToRegion');
		// $aRegion = explode(' ', $regions[$order->shipping->country]);
		if ($free) {
			$shippings = self::find('all', array('conditions'=>array('price' => 0)));	
		} else {
			$shippings = self::find('all', array('order'=>array('price'=>'ASC')));	
		}
		

		// foreach ($shippings as $key => $shipping) {
		// 	$territories = $shipping->territories->to('array');
		// 	$result = array_intersect($territories, $aRegion);
		// 	if (!count($result) && !in_array('001', $territories)) {
		// 		unset($shippings[(string)$shipping->_id]);
		// 	}
		// }
		return $shippings;

	}
}


?>
