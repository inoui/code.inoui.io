<?php

namespace app\extensions\payments;

use lithium\net\http\Router;

use app\models\Shops;
use app\extensions\payments\cybermut\CMCIC_Tpe;
use app\extensions\payments\cybermut\CMCIC_Hmac2;

class Cybermut extends \app\extensions\payments\Payment {

    public function control($data) {
        
    }

    function getForm($order, $request) {


        $sOptions   = "";
        $sReference = urlencode(substr($order->order_number, 0, 12));
        $sMontant   = number_format($order->total, 2, '.', '');

        // Currency : ISO 4217 compliant
        $sDevise  = "EUR";

        $prefs = unserialize($this->shop->payment_preferences);

        $lang = 'FR';
        $oTpe = new CMCIC_Tpe(array(
            'CMCIC_CLE' => $prefs['cybermut_key'],
            'CMCIC_TPE' => $prefs['cybermut_tpe'],
            'CMCIC_CODESOCIETE' => $prefs['cybermut_soc'],
            'LANG' => $lang,
            'CMCIC_VERSION' => '3.0',
            'CMCIC_SERVEUR' => 'https://paiement.creditmutuel.fr/',
            'CMCIC_URLOK' => Router::match(array('Checkout::confirm', 'id' => $order->order_number), $request, array('absolute'=>true)),
            'CMCIC_URLKO' => Router::match(array('Checkout::confirm', 'id' => $order->order_number), $request, array('absolute'=>true))
        ));
        $oHmac = new CMCIC_Hmac($oTpe);
        
        $curr = empty($this->shop->currency)?'EUR':$this->shop->currency;
        $montant = number_format($order->total, 2, '.', '');
        $sDate = date("d/m/Y:H:i:s");


        $fields = sprintf("%s*%s*%s%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s",
                $oTpe->sNumero, $sDate, $montant, $curr,
                urlencode(substr($order->order_number, 0, 12)), $order->order_number, $oTpe->sVersion, $oTpe->sLangue, $oTpe->sCodeSociete, $order->email, 
                "", "", "", "", "", "", "", "", "", "");
        
        $sMAC = $oHmac->computeHmac($fields);


		$form = <<<EOS
        <html>
            <script>document.forms['cybermut_form'].submit();</script>
        <body>

            <form action="{$oTpe->sUrlPaiement}" method="post" name="cybermut_form" id="PaymentRequest">
            	<input type="hidden" name="version"             id="version"        value="{$oTpe->sVersion}" />
            	<input type="hidden" name="TPE"                 id="TPE"            value="{$oTpe->sNumero}" />
            	<input type="hidden" name="date"                id="date"           value="{$sDate}" />
            	<input type="hidden" name="montant"             id="montant"        value="{$montant}{$curr}" />
            	<input type="hidden" name="reference"           id="reference"      value="{$sReference}" />
            	<input type="hidden" name="MAC"                 id="MAC"            value="{$sMAC}" />
            	<input type="hidden" name="url_retour"          id="url_retour"     value="{$oTpe->sUrlKO}" />
            	<input type="hidden" name="url_retour_ok"       id="url_retour_ok"  value="{$oTpe->sUrlOK}" />
            	<input type="hidden" name="url_retour_err"      id="url_retour_err" value="{$oTpe->sUrlKO}" />
            	<input type="hidden" name="lgue"                id="lgue"           value="{$oTpe->sLangue}" />
            	<input type="hidden" name="societe"             id="societe"        value="{$oTpe->sCodeSociete}" />
            	<input type="hidden" name="texte-libre"         id="texte-libre"    value="{$order->order_number}" />
            	<input type="hidden" name="mail"                id="mail"           value="{$order->email}" />
            </form>
        </body>
EOS;
        return $form;
    }

}

?>