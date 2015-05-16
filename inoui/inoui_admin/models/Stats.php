<?php

namespace inoui_admin\models;
use \lithium\g11n\Message;
use \lithium\data\Connections;
use inoui_ecomm\models\Orders;
use inoui\models\Newsletters;
use inoui_ecomm\extensions\g11n\Currency;
class Stats extends \lithium\core\StaticObject {
    

	public static function totalSales() {
		$orders = Orders::all();
		
        $mongodb = Connections::get('default')->connection;
        $results = $mongodb->orders->aggregate(array(
			array(
				'$match' => array('status' => array('$in' => array('ready', 'shipped'))),
			),
			array(				
		         '$group' => array(
		            '_id' => null,
		            'total_sales' => array('$sum' => '$total')
		         )
			)
        ));

		$total = count($results['result']) ? $results['result'][0]['total_sales']:0;

		return Currency::format($total);
		
		

		// 	array('$sum' => 'token_get_all'), 
		//   	array('_id' => $cart->_id), 
		//   	array('atomic' => false)
		// );
		// 
		// 
		// $total = Orders::connection()->connection->command(array('$sum'=>'total'));
		// print_r($total);
		
		
		// $result = $db->command(array(
		//    'aggregate' => 'projectMetrics',
		//    'pipeline' => array(
		//       array(
		//          '$match' => array('mobile' => true)
		//       ),
		//       array(
		//          '$group' => array(
		//             '_id' => '$projectUrl',
		//             'pageviews' => array('$sum' => '$v.pageviews')
		//          )
		//       ),
		//       array(
		//          '$sort' => array('date': -1),
		//       ),
		//       array(
		//          '$limit' => 20
		//       )
		//    ))
		// ));

	}
	public static function 	totalUsers() {
		return Newsletters::count();
	}

	public static function 	orders($w = null) {
		if ($w == null) {
			$conditions = array('status' => array('$in' => array('ready', 'shipped')));
		} else {
			$conditions = array('status' => $w);
		}
		return Orders::count(compact('conditions'));
	}
	
	public static function getLastOrders($limit) {

		$conditions = array('status'=>array('$in' => array('ready', 'shipped')));
		$order = array('updated'=>'DESC');
		$limit = $limit;
		$orders = Orders::find('all', compact('conditions', 'order'));
		return $orders;
	}
}
?>