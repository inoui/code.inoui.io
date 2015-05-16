<?php

namespace app\extensions\payments\cybermut;

class CMCIC_Hmac2 {

	private $_sUsableKey;	// La clé du TPE en format opérationnel / The usable TPE key

	// ----------------------------------------------------------------------------
	//
	// Constructeur / Constructor
	//
	// ----------------------------------------------------------------------------

	function __construct($oTpe) {
		
		$this->_sUsableKey = $this->_getUsableKey($oTpe);
	}

	// ----------------------------------------------------------------------------
	//
	// Fonction / Function : _getUsableKey
	//
	// Renvoie la clé dans un format utilisable par la certification hmac
	// Return the key to be used in the hmac function
	//
	// ----------------------------------------------------------------------------

	private function _getUsableKey($oTpe){

		$hexStrKey  = substr($oTpe->getCle(), 0, 38);
		$hexFinal   = "" . substr($oTpe->getCle(), 38, 2) . "00";
    
		$cca0=ord($hexFinal); 

		if ($cca0>70 && $cca0<97) 
			$hexStrKey .= chr($cca0-23) . substr($hexFinal, 1, 1);
		else { 
			if (substr($hexFinal, 1, 1)=="M") 
				$hexStrKey .= substr($hexFinal, 0, 1) . "0"; 
			else 
				$hexStrKey .= substr($hexFinal, 0, 2);
		}


		return pack("H*", $hexStrKey);
	}

	// ----------------------------------------------------------------------------
	//
	// Fonction / Function : computeHmac
	//
	// Renvoie le sceau HMAC d'une chaine de données
	// Return the HMAC for a data string
	//
	// ----------------------------------------------------------------------------

	public function computeHmac($sData) {
		return strtolower(hash_hmac("sha1", $sData, $this->_sUsableKey));
	}

}

?>