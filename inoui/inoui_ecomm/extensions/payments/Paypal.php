<?php

namespace inoui_ecomm\extensions\payments;
use lithium\analysis\Logger;
use lithium\net\http\Router;
use lithium\core\Libraries;
use \lithium\core\Environment;
use app\models\Shops;

class Paypal extends \inoui_ecomm\extensions\payments\Payment {


    public $_params = array(        
        'url' => 'https://www.paypal.com/cgi-bin/webscr'
    );
    
    public function control($data) {
		Logger::debug("ORDER Paybox " . date("D M j G:i:s") . print_r($data, 1));

        include_once INOUI_LIBRARY_PATH . "/inoui_ecomm/extensions/payments/paypal/paypal.class.php";
        
        // $merchandId = $this->shop->paypal_email;

        $p = new paypal_class();
        $p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';

        if ($p->validate_ipn()) {
            $this->status = 'ready';
        } else {
		    error_log(print_r($request, 1), 1,"support@inoui.io");

            $this->status = 'error';
        }
        $this->order_number = $p->ipn_data['item_number'];
    }

    function getForm($order, $request) {

        include_once INOUI_LIBRARY_PATH . "/inoui_ecomm/extensions/payments/paypal/paypal.class.php";

        //Affectation des paramètres obligatoires

        $p = new paypal_class();
        $p->paypal_url = $this->_params['url'];
        
        $p->add_field('first_name', $order->first_name);
        $p->add_field('last_name', $order->last_name);
        $p->add_field('address1', $order->address1);
        $p->add_field('address2', $order->address2);
        $p->add_field('country', $order->country);
        $p->add_field('zip', $order->post_code);
        $p->add_field('city', $order->city);
        $p->add_field('email', $order->email);


		$config = Libraries::get('inoui_ecomm');
		
        $prefs = $config['payment'];
        
        $p->add_field('business', $prefs['paypal_email']);
        

		$locale			=  Environment::get('locale');

        $retour = Router::match(array('Checkout::confirm', 'id' => $order->order_number, 'library'=>'inoui_ecomm', 'locale'=>$locale), $request, array('absolute'=>true));
        $p->add_field('return', $retour);
        $p->add_field('cancel_return', $retour);

        $notify_url     = Router::match(array('Checkout::validate', 'library'=>'inoui_ecomm', 'locale'=>$locale), $request, array('absolute'=>true));
        $p->add_field('notify_url', $notify_url);
        $p->add_field('item_name', $prefs['shop_name']);
        $curr = 'EUR';

        $p->add_field('currency_code', $curr);
        
        $p->add_field('item_number', $order->order_number);
		$amount = number_format($order->total,2, '.', '');
        $p->add_field('amount', $amount);

        $form = $p->submit_paypal_post();

        return $form;
    }

}

?>