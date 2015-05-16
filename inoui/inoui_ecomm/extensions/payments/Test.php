<?php

namespace inoui_ecomm\extensions\payments;
use lithium\net\http\Router;
use app\models\Shops;
use \lithium\g11n\Message;

class Test extends \inoui_ecomm\extensions\payments\Payment {

    public $redirect = true;
    
    public function control($request) {
        $this->order_number = $request->data['order_number'];
        $this->status = 'ready';
    }

    public function setStatus() {
        parent::setStatus();
        $this->redirect = array("Checkout::confirm", 'id' => $this->order->order_number, 'library' => 'inoui_ecomm');
    }

    function getForm($order, $request) {
        extract(Message::aliases());
        
        $notify_url     = Router::match(array('Checkout::validate', 'library' => 'inoui_ecomm'), $request, array('absolute'=>true));
        $return_url     = Router::match(array('Checkout::confirm', 'id'=>$order->order_number, 'library' => 'inoui_ecomm'), $request, array('absolute'=>true));



        $form = <<<EOF
	        <html>
	        <body>

        <form action = '{$notify_url}' method = 'post' name = 'paybox_form' style='padding:20px;'>
            <input type='hidden' name='order_number' value='{$order->order_number}' />
            <input type="submit" name="validate" value="valid" id="validate"/>
        </form>
            <script>document.forms['paybox_form'].submit();</script>
        </body>


        
EOF;

        return $form;
    }

}

?>