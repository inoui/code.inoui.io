<?php

namespace app\extensions\payments;
use lithium\net\http\Router;
use app\models\Shops;
use app\models\Orders;

class Invit extends \app\extensions\payments\Payment {

    public $redirect = true;
    
    public function control($request) {
        $this->order_number = $request->data['invit'];
    }

    public function setStatus() {

        if (!empty($this->order_number)) {
            $this->order = Orders::first(array('conditions' => array('order_number' => $this->order_number)));
            $total = (int)$this->order->total;
            if (empty($total)) {
                $this->status = 2;
            } else {
                $this->status = 1;
            }
            $this->order->setStatus($this->status);
            $this->order->save();
        }

        $this->redirect = array("Checkout::confirm", 'id' => $this->order->order_number, 'shop'=>Shops::getShop()->slug);
    }


    function getForm($order, $request) {
        $notify_url     = Router::match(array('Checkout::validate'), $request, array('absolute'=>true));
        $return_url     = Router::match(array('Checkout::confirm', 'id'=>$order->order_number), $request, array('absolute'=>true));

        $form = <<<EOF
        <form action = '{$notify_url}' name="invit_form" method = 'post' style='padding:20px;'>
            <input type='hidden' name='invit' value='{$order->order_number}' />
        </form>
        <script>document.forms['invit_form'].submit();</script>

EOF;


        return $form;
    }

}

?>