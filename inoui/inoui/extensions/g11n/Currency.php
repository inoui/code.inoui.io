<?php

namespace inoui\extensions\g11n;

use \lithium\g11n\Message;
use lithium\core\Environment;
use app\models\Shops;
use NumberFormatter;

class Currency {

//    protected static $_taux = '19.6';

	public function format($val, $currency = 'EUR') {
        $locale     = Environment::get('locale');
        $fmt = numfmt_create( $locale, NumberFormatter::CURRENCY );
        return numfmt_format_currency($fmt, $val, $currency);
	}

    // public function formatht($val) {
    //         $valht = $val / (1 + Currency::$_taux / 100);
    //         $fmt = numfmt_create( 'fr_FR', NumberFormatter::CURRENCY );
    //         return numfmt_format_currency($fmt, $valht, "EUR");
    // }
    // 
    // public function vat($val) {
    //         $valht = $val / (1 + Currency::$_taux / 100);
    //         $vat = $val-$valht;
    //         $fmt = numfmt_create( 'fr_FR', NumberFormatter::CURRENCY );
    //         return numfmt_format_currency($fmt, $vat, "EUR");
    // }
    // 

}

?>