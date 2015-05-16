<?php
namespace inoui_ecomm\extensions\helper;

use lithium\net\http\Router;
use lithium\analysis\Logger;
use lithium\core\Environment;
use lithium\security\Auth;
use lithium\core\Libraries;


class Payment extends \lithium\template\Helper {

    function createForm($order) {
	
		$config = Libraries::get('inoui_ecomm');
        $gateway = $config['payment']['gateway'];

        $total = (int)$order->total;
        $class = '\\inoui_ecomm\\extensions\\payments\\' . ucfirst($gateway);
        $oPayment = new $class();
        return $oPayment->getForm($order, $this->_context->request());
    }

    static function control($request) {
		$config = Libraries::get('inoui_ecomm');
        $gateway = $config['payment']['gateway'];

        $class = '\\inoui_ecomm\\extensions\\payments\\' . ucfirst($gateway);
        $oPayment = new $class();
        $oPayment->control($request);
        $oPayment->setStatus();
        return $oPayment;
    }

}

?>