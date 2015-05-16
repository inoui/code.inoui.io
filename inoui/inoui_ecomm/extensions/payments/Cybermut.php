<?php

namespace app\extensions\payments;

use lithium\net\http\Router;

use app\models\Shops;
use app\extensions\payments\cybermut\CMCIC_Hmac;
use lithium\core\Environment;

class Cybermut extends \app\extensions\payments\Payment {

    private $oTpe = array();

    public function control($request) {
        Environment::set(true, array('locale' => 'en'));
        $this->order_number = $request->data['texte-libre'];
        if ($request->data['code-retour'] == 'paiement' || $request->data['code-retour'] == 'payetest') $this->status = 2;
        else $this->status = 1;
    }

    function getForm($order, $request) {


        $sOptions   = "";
        $sReference = urlencode(substr($order->order_number, 0, 12));
        $sMontant   = number_format($order->total, 2, '.', '');

        // Currency : ISO 4217 compliant
        $sDevise  = "EUR";

        $prefs = unserialize($this->shop->payment_preferences);

        $lang = 'FR';
        $this->aTpe = array(
            'key' => $prefs['cybermut_key'],
            'tpe' => $prefs['cybermut_tpe'],
            'soc' => $prefs['cybermut_soc'],
            'retour' => Router::match(array('Checkout::validate'), $request, array('absolute'=>true)),
            'retourok' => Router::match(array('Checkout::confirm', 'id' => $order->order_number), $request, array('absolute'=>true)),
            'retourko' => Router::match(array('Checkout::confirm', 'id' => $order->order_number), $request, array('absolute'=>true))
        );

        $curr = empty($this->shop->currency)?'EUR':$this->shop->currency;
        $montant = number_format($order->total, 2, '.', '');
        $sDate = date("d/m/Y:H:i:s");


        $fields = sprintf("%s%s*%s*%s%s*%s*%s*%s*%s*%s*", '', 
                $prefs['cybermut_tpe'], 
                $sDate, 
                $montant, 
                $curr,
                urlencode(substr($order->order_number, 0, 12)), 
                $order->order_number, 
                "1.2open", 
                $lang, 
                $prefs['cybermut_soc']);

        $oHmac = new CMCIC_Hmac($this->aTpe, $fields);
        $sMAC = $oHmac->computeHmac();
        
		$form = <<<EOS
        <html>
            <script>document.forms['cybermut_form'].submit();</script>
        <body>

            <form action="https://paiement.creditmutuel.fr/paiement.cgi" method="post" name="cybermut_form" id="PaymentRequest">
            	<input type="hidden" name="version"             id="version"        value="1.2open" />
            	<input type="hidden" name="TPE"                 id="TPE"            value="{$this->aTpe['tpe']}" />
            	<input type="hidden" name="date"                id="date"           value="{$sDate}" />
            	<input type="hidden" name="montant"             id="montant"        value="{$montant}{$curr}" />
            	<input type="hidden" name="reference"           id="reference"      value="{$sReference}" />
            	<input type="hidden" name="MAC"                 id="MAC"            value="{$sMAC}" />
            	<input type="hidden" name="url_retour"          id="url_retour"     value="{$this->aTpe['retour']}" />
            	<input type="hidden" name="url_retour_ok"       id="url_retour_ok"  value="{$this->aTpe['retourok']}" />
            	<input type="hidden" name="url_retour_err"      id="url_retour_err" value="{$this->aTpe['retourko']}" />
            	<input type="hidden" name="lgue"                id="lgue"           value="{$lang}" />
            	<input type="hidden" name="societe"             id="societe"        value="{$this->aTpe['soc']}" />
            	<input type="hidden" name="texte-libre"         id="texte-libre"    value="{$order->order_number}" />
            </form>
        </body>
EOS;
        return $form;
    }

}

?>