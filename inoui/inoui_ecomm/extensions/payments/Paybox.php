<?php

namespace inoui_ecomm\extensions\payments;
use lithium\net\http\Router;
use app\models\Shops;
use lithium\analysis\Logger;
use \lithium\core\Environment;
use lithium\core\Libraries;
class Paybox extends \inoui_ecomm\extensions\payments\Payment {


    public function control($request) {
		Logger::debug("ORDER Paybox " . date("D M j G:i:s") . print_r($request, 1));
		$this->order_number = $request->query['Ref'];
        if (isset($request->query['Auto']) && $request->query['Erreur'] == '00000') {
			$this->status = 'ready';
		} else {
		    // error_log(print_r($request, 1), 1,"support@inoui.io");
			$this->status = 'error';
		}
    }

    function getForm($order, $request) {

		$config = Libraries::get('inoui_ecomm');

        $merchandId = $config['payment']['paybox_merchandId'];
        $site       = $config['payment']['paybox_site'];
        $rang       = $config['payment']['paybox_rang'];
		$locale			=  Environment::get('locale');
        $normal_return_url          = Router::match(array('Checkout::confirm', 'id' => $order->order_number, 'library'=>'inoui_ecomm', 'locale'=>$locale), $request, array('absolute'=>true));
        $cancel_return_url          = Router::match(array('Checkout::confirm', 'id' => $order->order_number, 'library'=>'inoui_ecomm', 'locale'=>$locale), $request, array('absolute'=>true));
        $automatic_response_url     = Router::match(array('Checkout::validate', 'library'=>'inoui_ecomm', 'locale'=>$locale), $request, array('absolute'=>true));

        $cgiUrl     = "/cgi-bin/modulev2.cgi";
        $price      = $order->total*100;
        $time = date("c");
		// $key = "517A835BF2E47A5845300C42F91B29AA9130D8D4EDBE8DB4413407F885A574EAA3B9C6EC786EC6A4CA10353EBB0BB47A91DB11AB8FEDC3BBB6519407E303B14E";
		//$key = "1B9314FF503E32C3E5F0750DA3F869175945E43A1EF8F0D6DB76A0D85C2F197E3DF3DB892396624EBF59916540337C270061D82BB4165B5E7AD54BF52C2ABAE2";
		$key = $config['payment']['key'];
//		$key = "D76BE6A8A1F85401376D59AD2457643B2E68599CB958BA4C1E55DCB466551F014FD3810B9315D60C46A136CACDC60D3086B46787A586B376B9ECAAD81B45F78C";
        
		$devise = 978;
		$retour = 'Mt:M;Ref:R;Auto:A;Erreur:E';
		$hash = 'SHA512';
		$hmac = $this->gen_hmac($site, $rang, $merchandId, $devise, $order->order_number, $order->email, $hash, $time, $price, $retour, $key, $automatic_response_url, $normal_return_url, $cancel_return_url);
	    

        $form = <<<EOF
        
        <html>
        <body>
            <form action = 'https://tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi' name = 'paybox_form' method = post>

                <input type='hidden' name = 'PBX_SITE' value='{$site}' />
                <input type='hidden' name = 'PBX_RANG' value='{$rang}' />
                <input type='hidden' name = 'PBX_IDENTIFIANT' value='{$merchandId}' />
                <input type='hidden' name = 'PBX_TOTAL' value='{$price}' />
                <input type='hidden' name = 'PBX_DEVISE' value='978' />
                <input type='hidden' name = 'PBX_CMD' value='{$order->order_number}' />
                <input type='hidden' name = 'PBX_PORTEUR' value='{$order->email}' />
                <input type='hidden' name = 'PBX_RETOUR' value='{$retour}' />
                <input type='hidden' name = 'PBX_HASH' value='{$hash}' />
                <input type='hidden' name = 'PBX_TIME' value='{$time}' />

                <input type='hidden' name = 'PBX_REPONDRE_A' value='{$automatic_response_url}' />
                <input type='hidden' name = 'PBX_EFFECTUE' value='{$normal_return_url}' />
                <input type='hidden' name = 'PBX_REFUSE' value='{$cancel_return_url}' />
                <input type='hidden' name = 'PBX_ANNULE' value='{$cancel_return_url}' />

                <input type='hidden' name = 'PBX_HMAC' value='{$hmac}' />
				

            </form>
            <script>document.forms['paybox_form'].submit();</script>
        </body>
EOF;



        return $form;
    }

	function gen_hmac($site, $rang, $identifiant, $devise, $cmd, $porteur, $hash, $time, $total, $retour, $key, $automatic_response_url, $normal_return_url, $cancel_return_url) {
	    $msg = "PBX_SITE=". $site 
	        ."&PBX_RANG=". $rang 
	        ."&PBX_IDENTIFIANT=". $identifiant 
	        ."&PBX_TOTAL=". $total 
	        ."&PBX_DEVISE=". $devise 
	        ."&PBX_CMD=". $cmd 
	        ."&PBX_PORTEUR=". $porteur 
	        ."&PBX_RETOUR=". $retour 
	        ."&PBX_HASH=". $hash 
	        ."&PBX_TIME=" . $time
	        ."&PBX_REPONDRE_A=" . $automatic_response_url
	        ."&PBX_EFFECTUE=" . $normal_return_url
	        ."&PBX_REFUSE=" . $cancel_return_url
	        ."&PBX_ANNULE=" . $cancel_return_url;
	        $binkey = pack("H*", $key);
			Logger::debug("ORDER Paybox " . $msg);
	        $hmac = strtoupper(hash_hmac('SHA512', $msg, $binkey));
			Logger::debug("ORDER Paybox " . $hmac);
	    return $hmac;
	}


}

?>