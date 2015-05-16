<?php

namespace app\extensions\payments\cybermut;

class CMCIC_Hmac {

	private $pass = "GYOg3AaQS2To5-O212sF";
	private $aTpe = array();
	private $data = array();

	function __construct($aTpe, $data="") {
        $this->aTpe = $aTpe;
        $this->data = $data;
	}

    function hmac_sha1 ($key, $data) {
        $length = 64; // block length for SHA1
        if (strlen($key) > $length) { $key = pack("H*",sha1($key)); }
        $key  = str_pad($key, $length, chr(0x00));
        $ipad = str_pad('', $length, chr(0x36));
        $opad = str_pad('', $length, chr(0x5c));
        $k_ipad = $key ^ $ipad ;
        $k_opad = $key ^ $opad;

        return sha1($k_opad  . pack("H*",sha1($k_ipad . $data)));
    }

	public function computeHmac() {
        $k1 = pack("H*",sha1($this->pass));
        $l1 = strlen($k1);
        $k2 = pack("H*",$this->aTpe['key']);
        $l2 = strlen($k2);
        if ($l1 > $l2):
            $k2 = str_pad($k2, $l1, chr(0x00));
        elseif ($l2 > $l1):
            $k1 = str_pad($k1, $l2, chr(0x00));
        endif;

        if ($this->data == ""):
            $d = "CtlHmac1.2open".$this->aTpe['tpe'];
        else:
            $d = $this->data;
        endif;

        return strtolower($this->hmac_sha1($k1 ^ $k2, $d));

	}

}

?>